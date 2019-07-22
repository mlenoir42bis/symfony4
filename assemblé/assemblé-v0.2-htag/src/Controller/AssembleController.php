<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Assemble;
use App\Repository\AssembleRepository;

class AssembleController extends AbstractController {
    /**
     * @Route("/assemble/details/{id}", name="assemble-details")
     */
    public function pageAssembleDetails(Assemble $assemble) {

        //var dump symfony
        //dd($assemble);

        return $this->render("assemble/assembleDetails.html.twig", [
            'assembles' => $assemble
        ]);
    }

}
