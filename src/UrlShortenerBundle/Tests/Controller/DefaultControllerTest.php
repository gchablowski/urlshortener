<?php

namespace UrlShortenerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/aaa');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('url', $data);
        $this->assertArrayHasKey('short_code', $data);
               
        $crawler = $client->request('GET', '/lorem');
        
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

    }
}
