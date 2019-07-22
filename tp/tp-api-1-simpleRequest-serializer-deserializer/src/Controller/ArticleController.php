<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Article;

class ArticleController extends AbstractController {

    /**
     * @Route("/articles", name="createAction")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $data = $request->getContent();
        $article = $this->get('serializer')->deserialize($data, 'App\Entity\Article', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
    
    /**
     * @Route("/articles/{id}", name="article_show")
     * @Method("GET")
     */
    public function showAction(Article $article) {
        $data = $this->get('serializer')->serialize($article, 'json');
        $response =  new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

}