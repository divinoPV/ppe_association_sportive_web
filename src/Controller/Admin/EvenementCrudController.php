<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evenement::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'titre de l\'évenement'),
            TextEditorField::new('description', 'description de l\'évenement'),
            DateField::new('debut', 'début de l\'évenement'),
            DateField::new('fin', 'fin de l\'évenement'),
            DateField::new('creer', 'date création')->hideOnForm(),
            DateField::new('modifier', 'date modification')->hideOnForm(),
            NumberField::new('nombrePlaces', 'nombre de place'),
            AssociationField::new('categorie')->autocomplete(),
            AssociationField::new('sport')->autocomplete(),
            AssociationField::new('type')->autocomplete(),
        ];
    }

}
