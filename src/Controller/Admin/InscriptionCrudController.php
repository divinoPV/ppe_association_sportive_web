<?php

namespace App\Controller\Admin;

use App\Entity\Inscription;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

/**
 * IMPORTANT !
 * Ce CRUD ne fonctionne pas car EasyAdmin ne supporte pas les clés composite
 * EasyAdmin prévoit de supporter ses clés prochainement
 */
class InscriptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Inscription::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Inscription')
            ->setEntityLabelInPlural('Inscriptions')
            ->setPageTitle('index', 'Admin - Inscriptions')
            ->setPageTitle('edit', 'Admin - Editer Inscription')
            ->setPageTitle('new', 'Admin - Ajouter Inscription');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('utilisateur')
                ->setRequired(true),
            AssociationField::new('evenement')
                ->setRequired(true),
            DateField::new('creerLe', 'début de l\'évenement')
                ->hideOnForm(),
        ];
    }

}
