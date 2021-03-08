<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\Inscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IncriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 24; $i++){
            $inscription = new Inscription();

            /** @var User $user */
            $user = $this->getReference('eleve'.rand(1,24));
            /** @var Evenement $evenement */
            $evenement = $this->getReference('evenement'.rand(1,24));

            $inscription
                ->setCreatedAt()
                ->setEvenement($evenement)
                ->setUser($user);

            $manager->persist($inscription);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            EvenementFixtures::class,
            UserFixtures::class
        ];
    }
}
