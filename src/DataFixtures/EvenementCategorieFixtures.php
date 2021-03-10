<?php


namespace App\DataFixtures;

use App\Entity\EvenementCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EvenementCategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $eventCateg = [
            "Activité Sportive",
            "Compétiton",
            "Compétition amateur",
            "Championat",
            "Tournoi",
            "Journée découverte",
            "Journée associative"
        ];

        foreach ($eventCateg as $id => $categ){
            $uneCateg = new EvenementCategorie();
            $uneCateg->setNom($categ);

            $manager->persist($uneCateg);
            $this->addReference('eventCateg'.$id, $uneCateg);
        }
        $manager->flush();
    }
}