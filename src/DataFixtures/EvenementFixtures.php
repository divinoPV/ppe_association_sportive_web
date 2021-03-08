<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Entity\Sport;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EvenementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 25; $i++) {

            $evenement = new Evenement();

            $evenement
                ->setNom('evenementSv'.$i)
                ->setDescription('evenementScolaire'.$i)
                ->setCreatedAt()
                ->setUpdatedAt()
                ->setDebut(new \DateTime('now'))
                ->setFin(new \DateTime('now'))
                ->setImage('photo'.$i)
                ->setVignette('vignette'.$i)
                ->setNombrePlaces(25);

            /** @var Categorie $uneCateg */
            $uneCateg = $this->getReference('categ'.rand(0, 3));
            /** @var Sport $sport */
            $sport = $this->getReference('sportSv'.rand(0,9));
            /** @var Type $type */
            $type = $this->getReference('type'.rand(0,2));


            $evenement
                ->setCategorie($uneCateg)
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
            CategorieFixtures::class,
            TypeFixtures::class
        ];
    }
}
