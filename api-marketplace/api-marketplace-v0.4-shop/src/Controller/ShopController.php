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

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Shop;
use App\Repository\ShopRepository;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

use Symfony\Component\HttpFoundation\Request;

class ShopController extends FOSRestController
{

/**
 *
 * @Delete("api/shop/{id}")
 * @View
 */
public function deleteShopAction(Shop $shop, EntityManagerInterface $manager) {

    $manager->remove($shop);
    $manager->flush($shop);

    return $this->view(
        $shop,
        Response::HTTP_OK,[]
        );
}

/**
 * 
 * @Get("api/shop/{id}")
 * @View
 */
public function GetShopByIdAction(Shop $shop) {
    return $this->view(
        $shop,
        Response::HTTP_OK,[]
        );
}

/**
 * GET Route annotation.
 * @Get("api/shop")
 * @View
 */
public function getShopAction(ShopRepository $shopRepository)
{
    $shop = $shopRepository->findAll();
    // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
    return $this->view(
        $shop,
        Response::HTTP_OK,[]
        );
}

/**
 * @Post(path = "api/shop", name = "shopAdd")
 * @Rest\View(StatusCode=201)
 * @ParamConverter("shop", converter="fos_rest.request_body")
 */
public function addShopAction(Shop $shop, Request $request) {

    $errors = $this->get('validator')->validate($shop);

    $repositoryUser = $this->getDoctrine()->getRepository(User::class);
    
    $userId = $request->get('userId');
    $user = $repositoryUser->find($userId);
    
    if (!$user){
        $errors = array();
        $errors[0]['property_path'] = "user";
        $errors[0]['message'] = "user is unckown";
        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }
    
    if (count($errors)) {
        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }
    
    $shop->setUser($user);

    $em = $this->getDoctrine()->getManager();
    $em->persist($shop);
    $em->flush();
    
    return $this->view(
        $shop,
        Response::HTTP_ACCEPTED,[]
        );

}


/**
 * PUT Route annotation.
 * @Put(path = "api/shop/{id}", name = "shopPut")
 * @Rest\View(StatusCode=201)
 * @ParamConverter("shop", converter="fos_rest.request_body")
 */
public function putShopAction(Shop $holdShop, Shop $shop, Request $request) {
 
    $errors = $this->get('validator')->validate($shop);

    $repositoryUser = $this->getDoctrine()->getRepository(User::class);
    
    $userId = $request->get('userId');
    $user = $repositoryUser->find($userId);
    
    if (!$user){
        $errors = array();
        $errors[0]['property_path'] = "user";
        $errors[0]['message'] = "user is unckown";
        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }

    if (count($errors)) {
        return $this->view($errors, Response::HTTP_BAD_REQUEST);
    }
    
    $em = $this->getDoctrine()->getManager();

    $holdShop->setUser($user);
    $holdShop->setTitle($shop->getTitle());
    $holdShop->setDescription($shop->getDescription());
    $holdShop->setAdress($shop->getAdress());
    $holdShop->setPostalCode($shop->getPostalCode());
    $holdShop->setCountry($shop->getCountry());
    $holdShop->setSiret($shop->getSiret());
    $holdShop->setDateAd($shop->getDateAd());

    $em->flush();
    
    return $this->view(
        $holdShop,
        Response::HTTP_ACCEPTED,[]
        );
}

}

