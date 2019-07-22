<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;

use App\Services\ImageHandler;

class IndexController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function pageHome(BookRepository $bookRepository, ImageHandler $handler) {
       
        //$handler->handle();

        $book = $bookRepository->findAll();
        
        //var dump symfony
        //dd($book);

        return $this->render("home.html.twig", [
            'books' => $book
        ]);
    }

    /**
     * @Route("/showById/{id}", name="showById")
     */
    public function pageShowById(Book $book) {
        return $this->render("showById.html.twig", [
            'book' => $book
        ]);
     }

    /**
     * @Route("/add", name="add")
     */
    public function pageAdd(EntityManagerInterface $manager, Request $request) {

        $form = $this->createForm(BookType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            
            $path = $this->getParameter('kernel.project_dir') . '/public/image';

            //dd($path);
            $book = $form->getData();

            $image = $book->getImage();
            $image->setPath($path);

            $manager->persist($book);
            $manager->flush();

        
            $this->addFlash(
                'notice',
                'Book ajouter avec succès !'
            );

            return $this->redirectToRoute('home');
            
        }

        return $this->render("add.html.twig", [
            'form' =>$form->createView(),
        ]);
     }

     /**
     * @Route("/edit/{id}", name="edit")
     */
    public function pageEdit(Book $book, EntityManagerInterface $manager, Request $request) {

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $path = $this->getParameter('kernel.project_dir') . '/public/image';

            //dd($path);
            $book = $form->getData();

            $image = $book->getImage();
            $image->setPath($path);

            $manager->flush();

            $this->addFlash(
                'notice',
                'Book Modifier avec succès !'
            );

            return $this->redirectToRoute('home');

        }

        return $this->render("edit.html.twig", [
            "book" => $book,
            'form' => $form->createView()
        ]);
     }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function pageDelete(Book $book, EntityManagerInterface $manager) {

        $manager->remove($book);
        $manager->flush($book);

        return $this->redirectToRoute('home');
     }


}
