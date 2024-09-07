<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\SearchBookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/', name: 'book_list')]
    public function index(Request $request, BookRepository $bookRepository): Response
    {
        // Étape 1 : Créer le formulaire de recherche
        $form = $this->createForm(SearchBookType::class);

        // Étape 2 : Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Étape 3 : Initialiser les livres (afficher tous les livres par défaut)
        $books = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Étape 4 : Récupérer le terme de recherche
            $searchData = $form->getData();

            // Étape 5 : Chercher les livres correspondants
            $books = $bookRepository->findByTitle($searchData['q']);
        } else {
            // Si le formulaire n'est pas soumis, afficher tous les livres
            $books = $bookRepository->findAll();
        }

        // Étape 6 : Renvoyer la vue avec le formulaire et les résultats
        return $this->render('book/index.html.twig', [
            'books' => $books,
            'search_form' => $form->createView(),
        ]);
    }

    #[Route('/book/{id}', name: 'book_detail')]
    public function detail(Book $book): Response
    {
        return $this->render('book/detail.html.twig', [
            'book' => $book
        ]);
    }

}


