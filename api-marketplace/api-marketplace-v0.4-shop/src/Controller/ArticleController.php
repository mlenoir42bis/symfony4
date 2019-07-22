<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

use Symfony\Component\HttpFoundation\Request;

class ArticleController extends FOSRestController
{

/**
 *
 * @Delete("api/articles/{id}")
 * @View
 */
public function deleteArticlesAction(Articles $articles, EntityManagerInterface $manager) {

    $manager->remove($articles);
    $manager->flush($articles);

    return $this->view(
        $articles,
        Response::HTTP_OK,[]
        );
}

/**
 * 
 * @Get("api/articles/{id}")
 * @View
 */
public function GetArticlesByIdAction(Articles $articles) {
    return $this->view(
        $articles,
        Response::HTTP_OK,[]
        );
}

/**
 * GET Route annotation.
 * @Get("api/articles")
 * @View
 */
public function getArticlesAction(ArticlesRepository $articlesRepository)
{
    $articles = $articlesRepository->findAll();
    // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
    return $this->view(
        $articles,
        Response::HTTP_OK,[]
        );
}

/**
 * @Post(path = "api/articles", name = "articlesAdd")
 * @Rest\View(StatusCode=201)
 * @ParamConverter("articles", converter="fos_rest.request_body")
 */
public function addArticlesAction(Articles $articles) {

    $errors = $this->get('validator')->validate($articles);

    if (count($errors)) {
        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($articles);
    $em->flush();
    

    return $this->view(
        $articles,
        Response::HTTP_CREATED,
        [
            'Location' => $this->generateUrl('articlesAdd', ['id' => $articles->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
        ]
        );

}


/**
 * PUT Route annotation.
 * @Put(path = "api/articles/{id}", name = "articlesPut")
 * @Rest\View(StatusCode=201)
 * @ParamConverter("articles", converter="fos_rest.request_body")
 */
public function putArticlesAction(Articles $holdArticles, Articles $articles, Request $request) {
 
    $errors = $this->get('validator')->validate($articles);

    if (count($errors)) {
        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }
    
    $em = $this->getDoctrine()->getManager();

    $holdArticles->setName($articles->getName());
    $holdArticles->setDescription($articles->getDescription());

    $em->flush();
    
    return $this->view(
        $holdArticles,
        Response::HTTP_ACCEPTED,[]
        );
    
}

}

