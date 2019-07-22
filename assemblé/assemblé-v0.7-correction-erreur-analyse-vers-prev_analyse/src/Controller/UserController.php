<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Assemble;
use App\Repository\AssembleRepository;
use App\Form\AssembleType;

use App\Entity\Files;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class UserController extends AbstractController {
    
    /**
     * @Route("/user/edit/assemble/{id}", name="user-edit-assemble")
     */
    public function pageActionEditAssemble(Assemble $assemble, EntityManagerInterface $manager, Request $request) {

        
        $this->denyAccessUnlessGranted('EDIT', $assemble);

        $form = $this->createForm(AssembleType::class, $assemble);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){

            $assemble = $form->getData();

            foreach ($assemble->getFiles() as $files) {
                foreach ($files->getFileUpload() as $file) {
                    
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    
                    
                    $fileBdd = new Files();
                    $fileBdd->setName($file->getClientOriginalName());
                    $fileBdd->setMyFile($fileName);
                    $fileBdd->setType($file->guessExtension());
                    
                    $assemble->addFil($fileBdd);
                    
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );
                    
                }
                $assemble->removeFil($files);
            }
            
            $manager->flush();

            $this->addFlash(
                'notice',
                'Book Modifier avec succès !'
            );

            return $this->redirectToRoute('home');

        }

        return $this->render("user/editAssemble.html.twig", [
            "assemble" => $assemble,
            'form' => $form->createView()
        ]);

     }

    /**
     * @Route("/user/delete/assemble/{id}", name="user-delete-assemble")
     */
    public function pageActionDeleteAssemble(Assemble $assemble, EntityManagerInterface $manager) {

        $this->denyAccessUnlessGranted('DELETE', $assemble);

        $manager->remove($assemble);
        $manager->flush($assemble);

        return $this->redirectToRoute('home');
     }


    /**
     * @Route("/user/add/assemble", name="user-add-assemble")
     */
    public function pageActionAddAssemble(EntityManagerInterface $manager, Request $request) {

        $form = $this->createForm(AssembleType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $assemble = $form->getData();

            foreach ($assemble->getFiles() as $files) {
                foreach ($files->getFileUpload() as $file) {

                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    
                    
                    $fileBdd = new Files();
                    $fileBdd->setName($file->getClientOriginalName());
                    $fileBdd->setMyFile($fileName);
                    $fileBdd->setType($file->guessExtension());
                    
                    $assemble->addFil($fileBdd);
                    
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );
                    
                }
                $assemble->removeFil($files);
            }
            

            $dt = new DateTime();
            $user = $this->getUser();

            $assemble->setUser($user);
            $assemble->setDateCrea();
            $assemble->setDateUpd();

            $manager->persist($assemble);
            $manager->flush();
        
            $this->addFlash(
                'notice',
                'Assemble ajouter avec succès !'
            );
        
            return $this->redirectToRoute('home');
            
        }

        return $this->render("user/addAssemble.html.twig", [
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/user/home", name="user-home")
     */
    public function pageActionUserHome()
    {

        $repository = $this->getDoctrine()->getRepository(Assemble::class);

        $user = $this->getUser();
        
        $assembles = $repository->findBy(
            ['user' => $user]
        );
        //dd($assembles);
        return $this->render("user/home.html.twig", [
            'assembles' =>$assembles,
        ]);
        
    }

}
