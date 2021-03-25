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
    public const DOC_LIST = 10;

    public function load(ObjectManager $manager)
    {
        $nbeEvent = 0;
        $nbeCategDoc = 0;

        for ($i = 0; $i < self::DOC_LIST; $i++) {

            $nbeEvent = $nbeEvent < EvenementFixtures::EVENT_LIST ? $nbeEvent + 1 : $nbeEvent = 0;
            $nbeCategDoc = $nbeCategDoc < CategDocFixtures::CATEG_DOC_LIST ? $nbeCategDoc + 1 : $nbeCategDoc = 0;

            $document = new Document();

            /** @var DocumentCategorie $categ */
            $categ = $this->getReference('categDoc' . $nbeCategDoc);

            $document
                ->setNom('document' . $i)
                ->setDescription('c\'est le document n°' . $i)
                ->setCategorie($categ)
                ->setCreerLe()
                ->setModifierLe()
                ->setLien('lien document n°' . $i);

            /** @var Evenement $evenement */
            $evenement = $this->getReference('evenement' . $nbeEvent);
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
