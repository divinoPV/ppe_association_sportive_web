<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $typeEven =[
            'public',
            'privée',
            'interne'
        ];

        for($i=0; $i<=2; $i++){
            $type = new Type();
            $type->setNom($typeEven[$i]);

            $manager->persist($type);
            $this->addReference('type'.$i, $type);
        }

        $manager->flush();
    }
}
