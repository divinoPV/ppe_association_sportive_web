<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Entity\Type;
use App\Entity\Sport;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class EvenementFixtures extends Fixture implements DependentFixtureInterface
{
    public const EVENT_NBR = 354;

    protected Generator $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        for ($i = 1; $i < EvenementFixtures::EVENT_NBR; $i++) {
            $number = rand(1, 7);

            $evenement = new Evenement();
            $evenement
                ->setNom($this->faker->sentence(rand(2, 9)))
                ->setDescription($this->faker->sentence(rand(47, 159)))
                ->setCreatedAt()
                ->setUpdatedAt()
                ->setDebut(new DateTime('now'))
                ->setFin(new DateTime('now'))
                ->setImage($number . '.png')
                ->setVignette($number . '.jpg')
                ->setNombrePlaces(rand(rand(12, 19), rand(38, 55)))
                ->setActif((bool)random_int(0, 1));

            /** @var Sport $sport */
            $sport = $this->getReference('sport' . rand(0, 15));
            /** @var Type $type */
            $type = $this->getReference('type' . rand(0, 6));
            /** @var Categorie $categorie */
            $categorie = $this->getReference('categ' . rand(0, 3));

            $evenement
                ->setType($type)
                ->setSport($sport)
                ->setCategorie($categorie);

            $manager->persist($evenement);
            $this->addReference('evenement' . $i, $evenement);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SportFixtures::class,
            TypeFixtures::class,
            CategorieFixtures::class
        ];
    }
}
