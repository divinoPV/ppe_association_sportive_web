<?php

namespace App\DataFixtures;

use App\Entity\DocumentCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategDocFixtures extends Fixture
{
    public const CATEG_DOC_LIST = 10;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= self::CATEG_DOC_LIST; $i++) {
            $categDoc = new DocumentCategorie();
            $categDoc->setNom('categDoc' . $i);

            $manager->persist($categDoc);
            $this->addReference('categDoc' . $i, $categDoc);
        }

        $manager->flush();
    }
}
