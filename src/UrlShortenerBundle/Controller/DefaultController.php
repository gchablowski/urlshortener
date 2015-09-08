<?php

namespace UrlShortenerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use UrlShortenerBundle\Entity\Url;
use UrlShortenerBundle\Form\UrlType;

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
    
    /**
     * post url action
     * @param Request $request
     * @return array() with a form
     *
     * @Rest\Post("/url/add", name="url_add")
     */
    public function urlAction(Request $request) {
        //create new object
        $url = new Url();

        //create form
        $form = $this->createForm(new UrlType(), $url);

        $form->handleRequest($request);

        if ($form->isValid()) {

           
        }

        return array(
            'form' => $form,
        );
    }
}
