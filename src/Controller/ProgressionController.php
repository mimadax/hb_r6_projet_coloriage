<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Progression;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProgressionController extends AbstractController
{
    #[Route('/progression/{book}', name: 'progression_index')]
    public function index(Book $book, EntityManagerInterface $em, Security $security): Response
    {
        $user = $this->getUser();

        $progressions = $em->getRepository(Progression::class)->findBy(['book' => $book, 'user' => $user]);

        $buttons = [];
        for ($i = 1; $i <= 100; $i++) {
            $button = $em->getRepository(Progression::class)->findOneBy(['book' => $book, 'buttonNumber' => $i, 'user' => $user]);
            if (!$button) {
                $button = new Progression();
                $button->setButtonNumber($i);
                $button->setIsChecked(false);
                $button->setBook($book);
                $button->setUser($user);
                $em->persist($button);
            }
            $buttons[$i] = $button;
        }

        $checked = count(array_filter($buttons, fn($p) => $p->isChecked()));
        $progression = $checked > 0 ? ($checked / 100) * 100 : 0;

        $em->flush();

        return $this->render('progression/index.html.twig', [
            'buttons' => $buttons,
            'progression' => $progression,
            'book' => $book,
        ]);
    }

    #[Route('/progression/update/{book}', name: 'progression_update', methods: ['POST'])]
    public function update(Book $book, Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $user = $this->getUser();
        $ids = $request->get('progression_ids', []);

        for ($i = 1; $i <= 100; $i++) {
            $progression = $em->getRepository(Progression::class)->findOneBy(['book' => $book, 'buttonNumber' => $i, 'user' => $user]) ?? new Progression();
            $progression->setButtonNumber($i);
            $progression->setIsChecked(in_array($i, $ids));
            $progression->setBook($book);
            $progression->setUser($user);

            $em->persist($progression);
        }

        $em->flush();

        return $this->redirectToRoute('progression_index', ['book' => $book->getId()]);
    }
}
