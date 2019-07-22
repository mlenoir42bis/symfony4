<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function pageHome() {
       return $this->render("home.html.twig");
    }

    /**
     * @Route("/{choice}", name="show")
     */
    public function pageShow($choice) {
        return $this->render("choice.html.twig", [
            'choice' => $choice,
        ]);
     }
    
    /**
     * @Route("/symfony/contact", name="contact")
     */
    public function pageContact() {
        return $this->render("contact.html.twig");
     }
}
