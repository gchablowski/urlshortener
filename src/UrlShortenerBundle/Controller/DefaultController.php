<?php

namespace UrlShortenerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;

class DefaultController extends Controller
{
    /**
     * Get url actions
     * @return object
     *
     * @Rest\Get("/{short_code}", name="get_url")
     */
    public function indexAction($short_code) {

        // get url object
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UrlShortenerBundle:Url')->findOneByShortCode($short_code);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find your email.');
        }

        //persist
        $entity->addCounter();
        $em->persist($entity);
        $em->flush();

        return $entity;
    }
}
