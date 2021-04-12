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
        "Junior garçcon",
    ];

    public const HEXA_LETTERS =
        ['A','B','C','D','E','F'];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEG_LIST as $id => $categ) {
            $uneCateg = new Categorie();
            $uneCateg
                ->setNom($categ)
                ->setColor('#' . self::randHexa())
            ;

            $manager->persist($uneCateg);

            $this->addReference('categ' . $id, $uneCateg);
        }

        $defaultCateg = new Categorie();
        $defaultCateg
            ->setNom('Autre')
            ->setColor('#' . self::randHexa())
        ;

        $manager->persist($defaultCateg);
        $manager->flush();
    }

    public static function randHexa(): string
    {
        $number = "";

        for ($i = 0; $i !== 6; $i++):
            $magic = rand(0,1);
            $magic === 0
                ? $number .= rand(0,9)
                : $number .= array_rand(self::HEXA_LETTERS)
            ;
        endfor;

        return $number;
    }
}
