<?php

namespace App\Controller;

use App\Entity\Image; // Assurez-vous que la classe Image est importée
use App\Form\UploadImageType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\FormError;

class ImageController extends AbstractController
{
    #[Route('/user/images', name: 'user_images')]
    public function index(ImageRepository $imageRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $images = $imageRepository->findBy(['user' => $user]);

        return $this->render('image/index.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/user/upload', name: 'user_upload')]
    public function upload(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UploadImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $filename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/images',
                        $filename
                    );

                    $image = new Image();
                    $image->setFilename($filename);
                    $image->setUser($this->getUser());

                    $em->persist($image);
                    $em->flush();

                } catch (FileException $e) {
                    $form->addError(new FormError("Erreur lors de l'upload du fichier"));
                }

                return $this->redirectToRoute('user_images');
            }
        }

        return $this->render('image/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
