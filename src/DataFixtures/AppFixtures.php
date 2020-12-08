<?php

  namespace App\DataFixtures;

  use App\Entity\Album;
  use App\Entity\Artist;
  use App\Entity\Style;

  use Doctrine\Bundle\FixturesBundle\Fixture;
  use Doctrine\Persistence\ObjectManager;

  use Faker;

 class AppFixtures extends Fixture
 {
     public function load(ObjectManager $manager)
      {
       $faker = Faker\Factory::create('fr_FR');
           // on crée 4 auteurs avec noms et prénoms "aléatoires" en français

           for ($i = 0; $i < 30; $i++) {
               $style= new Style();
               $style->setName($faker->name);
               $artist = new Artist();
               $artist->setName($faker->name);
               $artist->setStyle($style);
               $artist->setPicture($faker->imageUrl(300, 300));

               $manager->persist($artist);
               $manager->persist($style);

                for ($j = 0; $j < 12; $j++) {
                    $album = new Album();
                    $album->setName($faker->name);
                    $album->setReleaseYear($faker->numberBetween($min = 1900, $max = 2020));
                    $album->setArtist($artist);
                    $album->setCover($faker->imageUrl(300, 300));

    
                    $manager->persist($album);
                }
    
                $manager->flush();
        }
           }

   }