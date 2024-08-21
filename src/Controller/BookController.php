<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\SearchBookType;
use App\Model\SearchData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'book_list')]
    public function index(EntityManagerInterface $entityManager, BookRepository $bookRepository, Request $request): Response
    {
        $searchData = new SearchData();
        $searchForm = $this->createForm(SearchBookType::class, $searchData);
        $searchForm->handleRequest($request);

        $books = $bookRepository->findBySearch($searchData);

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'search_form' => $searchForm->createView(),
        ]);
    }

    #[Route('/book/{id}', name: 'book_detail')]
    public function detail(Book $book): Response
    {
        return $this->render('book/detail.html.twig', ['book' => $book]);
    }
}

