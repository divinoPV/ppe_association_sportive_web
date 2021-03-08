<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $tabCateg = [
            "Cadet",
            "Cadette",
            "Junior fille",
            "Junior garçcon"
        ];

        foreach ($tabCateg as $id => $categ)
        {
            $uneCateg = new Categorie();

            $uneCateg->setNom($categ);
            $manager->persist($uneCateg);
            $this->addReference('categ'.$id, $uneCateg);
        }
        $manager->flush();
    }
}
