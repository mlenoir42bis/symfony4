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

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Form\CommentType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;

class AssembleController extends AbstractController {
  
    /**
     * @Route("/assemble/details/{id}", name="assemble-details")
     */
    public function pageAssembleDetails(Assemble $assemble, EntityManagerInterface $manager, Request $request) {

        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
        
            $comment = $form->getData();

            $comment->setCreatedAt();
            $comment->setAssemble($assemble);
            $comment->setUser($this->getUser());
            
            $assemble->addComment($comment);

            $manager->persist($assemble);
            $manager->flush();
        
            $this->addFlash(
                'notice',
                'Commentaire ajouter avec succès !'
            );
        }

        return $this->render("assemble/assembleDetails.html.twig", [
            'assembles' => $assemble,
            'form' =>$form->createView()
        ]);
    }


}
