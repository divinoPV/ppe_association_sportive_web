<?php


namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $type = [
            "Activité Sportive",
            "Compétiton",
            "Compétition amateur",
            "Championat",
            "Tournoi",
            "Journée découverte",
            "Journée associative"
        ];

        foreach ($type as $id => $aType):
            $typeElement = new Type();
            $typeElement->setNom($aType);
            $manager->persist($typeElement);
            $this->addReference('type' . $id, $typeElement);
        endforeach;

        $manager->flush();
    }
}