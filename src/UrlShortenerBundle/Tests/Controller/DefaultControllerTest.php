<?php

namespace UrlShortenerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {

    protected function CreateApp() {
        // create kernel to have service
        $kernel = $this->createKernel();
        $kernel->boot();

        return $kernel;
    }

    public function testUrlAction() {
        $client = static::createClient();

        $crawler = $client->request('POST', '/url/add', array('urlshortener_url' => array('url' => 'bob')));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/url/add', array('urlshortener_url' => array('url' => 'http://www.google.com')));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //verify that the insert be done
        $kernel = $this->CreateApp();

        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $getInsert = $this->em->getRepository('UrlShortenerBundle:Url')->findBy(array('url' => 'http://www.google.com'));

        $this->assertCount(1, $getInsert);

    }

    public function testIndex() {
        
        //get an url in database
        $kernel = $this->CreateApp();
        
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $getUrl = $this->em->getRepository('UrlShortenerBundle:Url')->findBy(array('url' => 'http://www.google.com'));

        $this->assertCount(1, $getUrl);
        
        //make the test
        $client = static::createClient();

        $crawler = $client->request('GET', '/'.$getUrl[0]->getShortCode());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('url', $data);
        $this->assertArrayHasKey('short_code', $data);

        $crawler = $client->request('GET', '/lorem');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        
        //suppress mock on database
        $this->em->remove($getUrl[0]);
        $this->em->flush();
        
    }

}
