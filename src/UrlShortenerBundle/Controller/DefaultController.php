<?php

namespace UrlShortenerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use UrlShortenerBundle\Entity\Url;
use UrlShortenerBundle\Form\UrlType;
use UrlShortenerBundle\Services\Base62Services;

class DefaultController extends Controller {

    /**
     * Get url actions
     * @return object
     *
     * @Rest\Get("/{short_code}", name="getUrl")
     */
    public function indexAction($short_code) {

        // get url object
        $em = $this->getDoctrine()->getManager();

        $oEntity = $em->getRepository('UrlShortenerBundle:Url')->findOneByShortCode($short_code);

        if (!$oEntity) {
            throw $this->createNotFoundException('Unable to find your email.');
        }

        //persist
        $oEntity->addCounter();
        $em->persist($oEntity);
        $em->flush();

        return $oEntity;
    }

    /**
     * post url action
     * @param Request $request
     * @return array() with a form
     *
     * @Rest\Post("/url/add", name="urlAdd")
     */
    public function urlAction(Request $request) {
        //create new Url object
        $oUrl = new Url();

        //create form
        $form = $this->createForm(new UrlType(), $oUrl);

        $form->handleRequest($request);

        if ($form->isValid()) {
            //get the futur id
            $em = $this->getDoctrine()->getManager();

            $iId = $em->getRepository('UrlShortenerBundle:Url')->countId();
            
            //create the url shortener
            $oShortenerSerivce = $this->container->get('urlshortener.base62');

            $sShort_code = $oShortenerSerivce->num_to_base62($iId + 1);
            
            // add the short_code to the $oUrl object
            $oUrl->setShortCode($sShort_code);
            
            //persist the new $oUrl      
            $em = $this->getDoctrine()->getManager();
            $em->persist($oUrl);
            $em->flush();

            return array(
                "code" => 200,
                "message" => "Your url is : ".$this->generateUrl("indexgetUrl", array('short_code' => $oUrl->getShortCode()), true),
                "errors" => null
            );
        }

        return array(
            'form' => $form,
        );
    }

}
