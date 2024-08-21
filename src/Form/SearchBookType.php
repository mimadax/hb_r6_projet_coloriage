<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', SearchType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un livre...',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Aucune classe de données nécessaire ici car ce formulaire est indépendant d'une entité.
        $resolver->setDefaults([
            'method' => 'GET',  // Utilisation de la méthode GET pour afficher la recherche dans l'URL.
            'csrf_protection' => false,  // Pas besoin de protection CSRF pour une recherche simple.
        ]);
    }
}
