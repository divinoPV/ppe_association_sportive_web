<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public const CATEG_LIST = [
        "Cadet",
        "Cadette",
        "Junior fille",
        "Junior garçcon"
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEG_LIST as $id => $categ) {
            $uneCateg = new Categorie();
            $uneCateg->setNom($categ);
            $manager->persist($uneCateg);
            $this->addReference('categ' . $id, $uneCateg);
        }
        $manager->flush();
    }
}
