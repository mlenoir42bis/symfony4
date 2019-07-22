<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Assemble;
use App\Repository\AssembleRepository;

class IndexController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function pageHome(AssembleRepository $assembleRepository) {

        $assemble = $assembleRepository->findAll();
        
        //var dump symfony
        //dd($book);

        return $this->render("home.html.twig", [
            'assembles' => $assemble
        ]);
    }

}
