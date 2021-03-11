<?php

namespace App\DataFixtures;

use App\Entity\Document;
use App\Entity\DocumentCategorie;
use App\Entity\Evenement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DocumentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++){
           $document = new Document();

           /** @var DocumentCategorie $categ */
           $categ = $this->getReference('categDoc'.rand(0,10));

           $document
               ->setNom('document'.$i)
               ->setDescription('c\'est le document n°'.$i)
               ->setCategorie($categ)
               ->setUpdatedAt()
               ->setCreatedAt()
               ->setLien('lien document n°'.$i);

           /** @var Evenement $evenement */
           $evenement = $this->getReference('evenement'.rand(1,25));
           $document->setEvenement($evenement);

           $manager->persist($document);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CategDocFixtures::class,
            EvenementFixtures::class
        ];
    }
}
