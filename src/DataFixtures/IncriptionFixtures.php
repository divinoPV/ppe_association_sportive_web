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
    public const INSCRIPTION_LIST = 200;

    public function load(ObjectManager $manager)
    {
        $nbeEvent = 0;
        $nbeUser = 0;
        for ($i = 0; $i < self::INSCRIPTION_LIST; $i++) {
            $nbeEvent = $nbeEvent < EvenementFixtures::EVENT_LIST - 1 ? $nbeEvent + 1 : $nbeEvent = 0;
            $nbeUser = $nbeUser < UtilisateurFixtures::USER_LIST - 1 ? $nbeUser + 1 : $nbeUser = 0;

            $inscription = new Inscription();

            /** @var User $user */
            $user = $this->getReference('eleve' . $nbeUser);
            /** @var Evenement $evenement */
            $evenement = $this->getReference('evenement' . $nbeEvent);

            $inscription
                ->setEvenement($evenement)
                ->setUtilisateur($user)
                ->setCreerLe();

            $manager->persist($inscription);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EvenementFixtures::class,
            UtilisateurFixtures::class
        ];
    }
}
