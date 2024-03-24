<?php

namespace App\DataFixtures;

use App\Entity\Livres;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i <= 10; $i++) { 

        $livre = new Livres;

        $livre->setTitreLivre('Titre ' . $i)
              ->setThemeLivre('Theme ' . $i);
        
        $manager->persist($livre);
        $manager->flush();
        }
    }
}
