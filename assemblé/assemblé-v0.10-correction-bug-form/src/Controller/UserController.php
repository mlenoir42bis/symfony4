<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Assemble;
use App\Repository\AssembleRepository;
use App\Form\AssembleType;

use App\Entity\Htag;
use App\Repository\HtagRepository;

use App\Entity\Files;
use App\Repository\FilesRepository;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Form\CommentType;

use App\Entity\Survey;
use App\Repository\SurveyRepository;
use App\Form\SurveyType;



use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController {


    /**
     * @Route(
     * "/user/delete/assemble/htag/{id}", 
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
     * "/user/delete/assemble/file/{id}", 
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
     * @Route("/user/add/assemble/survey/{id}", name="user-add-survey-assemble")
     */
    public function pageActionAddAssembleSurvey(Assemble $assemble, EntityManagerInterface $manager, Request $request) {

        $form = $this->createForm(SurveyType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $survey = $form->getData();
            
            $survey->setAssemble($assemble);
            $assemble->addSurvey($survey);

            $manager->persist($assemble);
            $manager->flush();
            
            $this->addFlash(
                'notice',
                'Sondage ajouter avec succès !'
            );
        
            return $this->redirectToRoute('assemble-details', array('id' => $assemble->getId()));
        }

        return $this->render("user/addSurveyAssemble.html.twig", [
            'form' =>$form->createView(),
            'assemble' =>$assemble,
        ]);
    }

    /**
     * @Route("/user/delete/assemble/survey/{id}", name="user-delete-survey-assemble", defaults={"idSurvey": 0, "idAssemble": 0})
     */
    public function pageActionDeleteAssembleSurvey(Survey $survey, EntityManagerInterface $manager, Request $request) {

        $idAssemble = $request->query->get('idAssemble');

        $repository = $this->getDoctrine()->getRepository(Assemble::class);
        $assemble = $repository->findOneBy(['id' => $idAssemble]);

        $this->denyAccessUnlessGranted('DELETE', $assemble);

        $manager->remove($survey);
        $manager->flush($survey);

        return $this->redirectToRoute('assemble-details', array('id' => $assemble->getId()));

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
