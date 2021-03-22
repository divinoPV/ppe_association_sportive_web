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
    public const INSCRIPTION_LIST = 24;
    public function load(ObjectManager $manager)
    {
        $nbeInscription = 0;
        $nbeUser = 0;
        for ($i = 0; $i <= self::INSCRIPTION_LIST; $i++) {
            $nbeInscription = $nbeInscription < EvenementFixtures::EVENT_LIST? $nbeInscription + 1 : $nbeInscription = 0;
            $nbeUser = $nbeUser < UtilisateurFixtures::USER_LIST ? $nbeUser + 1 : $nbeUser = 0;

            $inscription = new Inscription();

            /** @var User $user */
            $user = $this->getReference('eleve' . $nbeUser);
            /** @var Evenement $evenement */
            $evenement = $this->getReference('evenement' . $nbeInscription);

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
            UtilisateurFixtures::class
        ];
    }
}
