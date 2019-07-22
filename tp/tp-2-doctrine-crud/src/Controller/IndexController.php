<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function pageHome(BookRepository $bookRepository) {
       
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
    public function pageAdd(EntityManagerInterface $manager) {

        $test = new Book();

        $test->setTitle('test1');
        $test->setContent('test1 content');


        $test2 = new Book();

        $test2->setTitle('test2');
        $test2->setContent('test2 content');

        $test3 = new Book();

        $test3->setTitle('test3');
        $test3->setContent('test3 content');

        $manager->persist($test);
        $manager->persist($test2);
        $manager->persist($test3);

        $manager->flush();

        return $this->render("add.html.twig");
     }

     /**
     * @Route("/edit/{id}", name="edit")
     */
    public function pageEdit(Book $book, EntityManagerInterface $manager) {

        $book->setTitle("testEdit");

        $manager->flush($book);

        return $this->render("showById.html.twig", [
            "book" => $book
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
