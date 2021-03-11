<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            ImageField::new('imageFile', 'ajouter une image')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions(['allow_delete' => false])
                ->onlyOnForms(),
            ImageField::new('image', 'image')
                ->setBasePath($this->getParameter('app.path.featured_evenement_images'))
                ->hideOnForm(),
            ImageField::new('vignetteFile', 'ajouter une vignette')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions(['allow_delete' => false])
                ->onlyOnForms(),
            ImageField::new('vignette', 'vignette')
                ->setBasePath($this->getParameter('app.path.featured_evenement_vignettes'))
                ->hideOnForm(),
            DateField::new('debut', 'début de l\'évenement'),
            DateField::new('fin', 'fin de l\'évenement'),
            DateField::new('creer', 'date création')->hideOnForm(),
            DateField::new('modifier', 'date modification')->hideOnForm(),
            NumberField::new('nombrePlaces', 'nombre de place'),
            BooleanField::new('actif', 'actif')->renderAsSwitch(),
            AssociationField::new('type'),
            AssociationField::new('sport'),
            AssociationField::new('categorie'),
        ];
    }

}
