<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SportFixtures extends Fixture
{
    public const SPORT_LIST = [
        "Football",
        "Basketball",
        "Handball",
        "Natation",
        "Équitation",
        "Tenis",
        "Ping-pong",
        "Squash",
        "Rugby",
        "Football Américain",
        "Escalade",
        "Cricket",
        "Polo",
        "Golf",
        "Escrime",
        "Gymnastique",
        "Ski"
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SPORT_LIST as $id => $sport):
            $aSport = new Sport();
            $aSport->setNom($sport);

            $manager->persist($aSport);
            $this->addReference('sport' . $id, $aSport);
        endforeach;

        $manager->flush();
    }
}
