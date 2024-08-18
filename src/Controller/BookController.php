<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'book_list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $books = $entityManager->getRepository(Book::class)->findAll();

        return $this->render('book/index.html.twig', ['books' => $books]);
    }

    #[Route('/book/{id}', name: 'book_detail')]
    public function detail(Book $book): Response
    {
        return $this->render('book/detail.html.twig', ['book' => $book]);
    }
}
