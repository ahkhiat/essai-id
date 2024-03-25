<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Livres;
use App\Entity\Auteurs;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $auteur1 = new Auteurs;
        $auteur2 = new Auteurs;
        $auteur3 = new Auteurs;
        $auteur4 = new Auteurs;
        $auteur5 = new Auteurs;

        $auteur1->setNom('Rimbaud')
                ->setPrenom('Arthur');
        $auteur2->setNom('Camus')
                ->setPrenom('Albert');
        $auteur3->setNom('Zola')
                ->setPrenom('Emile');
        $auteur4->setNom('Hugo')
                ->setPrenom('Victor');
        $auteur5->setNom('Rousseau')
                ->setPrenom('Jean-Jacques');

        $manager->persist($auteur1);
        $manager->persist($auteur2);
        $manager->persist($auteur3);
        $manager->persist($auteur4);
        $manager->persist($auteur5);

        $listeAuteurs = [];
        $listeAuteurs += [$auteur1, $auteur2, $auteur3, $auteur4, $auteur5];
       
        for ($i=0; $i <= 10; $i++) { 

        $livre = new Livres;

        $livre->setTitreLivre('Titre ' . $i)
              ->setThemeLivre('Theme ' . $i)
              ->setAuteur($listeAuteurs[array_rand($listeAuteurs)]);
        
        $manager->persist($livre);
        // $manager->flush();
        }

        $user = new User;

        $user->setEmail("ahkhiat@hotmail.com")
             ->setRoles(["ROLE_ADMIN"])
             ->setNom("Leung")
             ->setPrenom("Thierry")
             ->setPassword($this->userPasswordHasher->hashPassword($user, "123456"));
        $manager->persist($user);

        $user1 = new User;

        $user1->setEmail("toto@hotmail.com")
             ->setRoles(["ROLE_USER"])
             ->setNom("Toto")
             ->setPrenom("Toto")
             ->setPassword($this->userPasswordHasher->hashPassword($user1, "123456"));
        $manager->persist($user1);

        $manager->flush();

    }
}
