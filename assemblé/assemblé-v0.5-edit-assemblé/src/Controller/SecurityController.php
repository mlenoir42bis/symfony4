<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;

use App\Security\LoginFormAuthenticator;

use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator, UserPasswordEncoderInterface $passwordEncoder)
    {
       $user = new User;

       $form = $this->createForm(RegistrationType::class, $user);

       if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

        $passwordEncoded = $passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($passwordEncoded);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();

        return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $loginFormAuthenticator,
            'main'
        );

       }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
