<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProgressionController extends AbstractController
{
    #[Route('/progression', name: 'app_progression')]
    public function index(): Response
    {
        return $this->render('progression/index.html.twig', [
            'controller_name' => 'ProgressionController',
        ]);
    }
}
