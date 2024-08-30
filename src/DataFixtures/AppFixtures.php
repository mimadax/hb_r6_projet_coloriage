<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // --- BOOKS------------------------------------------------
        for ($i = 0; $i < 10; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence())
                 ->setAuthor($faker->name())
                 ->setPublishedDate($faker->dateTimeBetween('-10 years'))
                 ->setDescription($faker->paragraph(3))
                 ->setImageFilename('https://picsum.photos/200/300');

            $manager->persist($book);
        }

                // --- USERS ---------------------------------------------------
                $admin = new User();
                $admin
                    ->setEmail("admin@test.com")
                    ->setRoles(["ROLE_ADMIN"])
                    ->setPassword($this->hasher->hashPassword($admin, "admin1234"));
        
                $manager->persist($admin);


                $user = new User();
                $user
                    ->setEmail("user@test.com")
                    ->setPassword($this->hasher->hashPassword($user, "test1234")); // Hachage du mot de passe
                    
                $manager->persist($user); // Enregistre l'utilisateur dans la base de données


                $manager->flush(); // Sauvegarde tout

    }
}