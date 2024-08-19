<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\SearchBookType;
use App\Model\SearchData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'book_list')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création du formulaire de recherche
    $searchData = new SearchData();
    $searchForm = $this->createForm(SearchBookType::class, $searchData);

    $searchForm->handleRequest($request);
    if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            dd($searchData);
        }

    // Récupérer tous les livres depuis la base de données
    $books = $entityManager->getRepository(Book::class)->findAll();
    
    // Rendre la vue avec le formulaire de recherche et les livres
    return $this->render('book/index.html.twig', [
        'books' => $books,
        'search_form' => $searchForm->createView(),  // Transmet le formulaire au template
    ]);

    }


    #[Route('/book/{id}', name: 'book_detail')]
    public function detail(Book $book): Response
    {
        return $this->render('book/detail.html.twig', ['book' => $book]);
    }
}

