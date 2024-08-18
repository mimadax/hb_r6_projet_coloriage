<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence())
                 ->setAuthor($faker->name())
                 ->setPublishedDate($faker->dateTimeBetween('-10 years'))
                 ->setDescription($faker->paragraph(3));

            $manager->persist($book);
        }

        $manager->flush();
    }
}