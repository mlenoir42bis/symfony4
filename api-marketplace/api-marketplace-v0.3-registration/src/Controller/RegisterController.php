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
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\UserManagerInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends FOSRestController
{

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @Post(path = "register", name = "register")
     * @Rest\View(StatusCode=201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function register(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $error = array();

        if ($user->getPassword() == '' || $user->getPassword() == null)
        {
            $error[] = 'Password is required';
        }
        if ($user->getUsername() == '' || $user->getUsername() == null)
        {
            $error[] = 'Username is required';
        }
        if ($user->getEmail() == '' || $user->getEmail() == null)
        {
            $error[] = 'Email is required';
        }
        
        for ($i = 0; $i < count($user->getRoles()); $i++)
        {
            if ($user->getRoles()[$i] != 'ROLE_BUYER' && $user->getRoles()[$i] != 'ROLE_SELLER' && $user->getRoles()[$i] != 'ROLE_USER') {
                $error[] = 'Roles is not correct';
            }
        }
        $userBdd = $this->userRepository->findOneBy([
            'email' => $user->getEmail(),
        ]);

        if (!is_null($userBdd)){
            $error[] = 'Email will be exist';
        }

        if (count($error)) {
            return $this->view($error, Response::HTTP_BAD_REQUEST);
        }

        $user->setPassword(
            $passwordEncoder->encodePassword($user, $user->getPassword())
        );
        $user->setEnabled(true);
         
        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return $this->view(
            $user,
            Response::HTTP_ACCEPTED,[]
            );
        

    }

}



?>