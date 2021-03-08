<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 25; $i++) {
            $user = new User();
            $password = '123';
            $user
                ->setEmail('eleve'.$i.'@gmail.com')
                ->setNom('NomEleve'.$i)
                ->setPrenom('PrenomEleve'.$i)
                ->setRoles('ROLE_USER')
                ->setCreer(new \DateTime('now'))
                ->setNaissance(new \DateTime('now'))
                ->setModifier(new \DateTime('now'))
                ->setPassword($this->encoder->encodePassword($user, $password))
                ->setForgottenPassword(false);

            /** @var Categorie $uneCateg */
            $uneCateg = $this->getReference('categ' . rand(0, 3));

            $user->setCategorie($uneCateg);
            $manager->persist($user);
            $this->addReference('eleve'.$i, $user);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class,
        ];
    }
}
