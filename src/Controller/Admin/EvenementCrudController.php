<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evenement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Evenement')
            ->setEntityLabelInPlural('Evenements')
            ->setTimezone('Europe/Paris')
            ->setPageTitle('index', 'Admin - Evenements')
            ->setPageTitle('edit', 'Admin - Editer Evenement')
            ->setPageTitle('new', 'Admin - Ajouter Evenement');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'titre de l\'évenement')->setRequired(true),
            TextField::new('description', 'description de l\'évenement')->setRequired(true)
                ->hideOnIndex(),
            ImageField::new('imageFichier', 'ajouter une image')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions(['allow_delete' => false])
                ->onlyOnForms(),
            ImageField::new('image', 'image')
                ->setBasePath($this->getParameter('app.path.featured_evenement_images'))
                ->hideOnForm(),
            ImageField::new('vignetteFichier', 'ajouter une vignette')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions(['allow_delete' => false])
                ->onlyOnForms(),
            ImageField::new('vignette', 'vignette')
                ->setBasePath($this->getParameter('app.path.featured_evenement_vignettes'))
                ->hideOnForm(),
            DateField::new('debuterLe', 'début de l\'évenement')->setRequired(true),
            DateField::new('finirLe', 'fin de l\'évenement')->setRequired(true),
            NumberField::new('nombrePlaces', 'nombre de place')->setRequired(true),
            BooleanField::new('actif', 'actif')->renderAsSwitch(),
            AssociationField::new('type')->setRequired(true)
                ->hideOnIndex(),
            AssociationField::new('sport')->setRequired(true)
                ->hideOnIndex(),
            AssociationField::new('categorie')->setRequired(true)
                ->hideOnIndex(),
        ];
    }

}
