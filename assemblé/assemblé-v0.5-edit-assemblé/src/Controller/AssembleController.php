<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Assemble;
use App\Repository\AssembleRepository;

use App\Entity\Htag;
use App\Repository\HtagRepository;

use App\Entity\Files;
use App\Repository\FilesRepository;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;

class AssembleController extends AbstractController {
  
    /**
     * @Route("/assemble/details/{id}", name="assemble-details")
     */
    public function pageAssembleDetails(Assemble $assemble) {

        return $this->render("assemble/assembleDetails.html.twig", [
            'assembles' => $assemble
        ]);
    }

    /**
     * @Route(
     * "/assemble/delete/htag/{id}", 
     * name="assemble-delete-htag"
     * )
     * 
     */
    public function pageActionDeleteHtag(Htag $htag, EntityManagerInterface $manager, Request $request) {

        $response = new Response();
        
        if ($request->isXmlHttpRequest()) {  
            $manager->remove($htag);
            $manager->flush($htag);

            $response->setContent(json_encode([
                'status' => 'Success',
                'message' => 'Success',
            ]));
            $response->headers->set('Content-Type', 'application/json');        
        }
        else {
            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'its not request ajax'),
            400);
        }

        return $response;

     }

    /**
     * @Route(
     * "/assemble/delete/file/{id}", 
     * name="assemble-delete-file"
     * )
     * 
     */
    public function pageActionDeleteFile(Files $files, EntityManagerInterface $manager, Request $request) {

        $response = new Response();
        
        if ($request->isXmlHttpRequest()) {  
            $manager->remove($files);
            $manager->flush($files);

            $response->setContent(json_encode([
                'status' => 'Success',
                'message' => 'Success',
            ]));
            $response->headers->set('Content-Type', 'application/json');        
        }
        else {
            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'its not request ajax'),
            400);
        }

        return $response;

     }

}
