<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SportFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<=9;$i++){
            $sport = new Sport();

            $sport->setNom('sportSv'.$i);
            $manager->persist($sport);
            $this->addReference('sportSv'.$i, $sport);
        }

        $manager->flush();
    }
}
