<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\SearchBookType;
use App\Model\SearchData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

    #[Route('/book/new', name: 'book_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Créer une nouvelle instance de Book
        $book = new Book();

        // Créer le formulaire BookType et le lier à l'entité Book
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer l'upload de l'image si un fichier est envoyé
            $imageFile = $form->get('imageFilename')->getData();

            if ($imageFile) {
                // Générer un nom de fichier unique pour éviter les conflits
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    // Déplacer l'image vers le dossier de stockage
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si l'upload échoue
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                }

                // Stocker le nom du fichier dans l'entité Book
                $book->setImageFilename($newFilename);
            }

            // Persister le livre en base de données
            $em->persist($book);
            $em->flush();

            // Ajouter un message flash de succès et rediriger vers la liste des livres
            $this->addFlash('success', 'Le livre a été ajouté avec succès.');
            return $this->redirectToRoute('book_list');
        }

        // Afficher le formulaire d'ajout de livre
        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/book/{id}', name: 'book_detail')]
    public function detail(Book $book): Response
    {
        return $this->render('book/detail.html.twig', ['book' => $book]);
    }
}

