<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class IndexController extends FOSRestController
{

/**
 * GET Route annotation.
 * @Get("/test")
 */
public function testAction() {
    $response = new JsonResponse(['data' => 'test']);
    return $response;
}

/**
 * GET Route annotation.
 * @Get("/testGetById/{id}")
 * @View
 */
public function testGetByIdAction(Articles $articles) {
    return $articles;
}

/**
 * @Post(path = "/testAdd", name = "testAdd")
 * @Rest\View(StatusCode=201)
 * @ParamConverter("articles", converter="fos_rest.request_body")
 */
public function testAddAction(Articles $articles) {

    
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($articles);
    $em->flush();
    

    return $this->view(
        $articles,
        Response::HTTP_CREATED,
        [
            'Location' => $this->generateUrl('testAdd', ['id' => $articles->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
        ]
        );
    
    //return $articles;
    //dump($articles); die;
}


}

