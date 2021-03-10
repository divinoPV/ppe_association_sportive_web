<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\EvenementCategorie;
use App\Entity\Sport;
use App\Entity\Type;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class EvenementFixtures extends Fixture implements DependentFixtureInterface
{
    protected Generator $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($i = 1; $i < 25; $i++) {
            $number = rand(1, 7);

            $evenement = new Evenement();
            $evenement
                ->setNom($this->faker->sentence(rand(2, 9)))
                ->setDescription($this->faker->sentence(rand(47, 159)))
                ->setCreatedAt()
                ->setUpdatedAt()
                ->setDebut(new DateTime('now'))
                ->setFin(new DateTime('now'))
                ->setImage($number.'.jpg')
                ->setVignette($number.'.jpg')
                ->setNombrePlaces(rand(rand(12, 19), rand(38, 55)))
                ->setActif((bool)random_int(0, 1))
            ;

            /** @var EvenementCategorie $categ */
            $categ = $this->getReference('eventCateg'.rand(0, 6));
            /** @var Sport $sport */
            $sport = $this->getReference('sport'.rand(0,15));
            /** @var Type $type */
            $type = $this->getReference('type'.rand(0,2));


            $evenement
                ->setEvenementCategorie($categ)
                ->setType($type)
                ->setSport($sport);

            $manager->persist($evenement);
            $this->addReference('evenement'.$i, $evenement);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            SportFixtures::class,
            EvenementCategorieFixtures::class,
            TypeFixtures::class
        ];
    }
}
