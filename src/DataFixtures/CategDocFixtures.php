<?php

namespace App\DataFixtures;

use App\Entity\DocumentCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategDocFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 10; $i++){
            $categDoc = new DocumentCategorie();

            $categDoc->setNom('categDoc'.$i);
            $manager->persist($categDoc);
            $this->addReference('categDoc'.$i,$categDoc);
        }

        $manager->flush();
    }
}
