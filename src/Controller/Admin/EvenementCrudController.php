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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
            TextEditorField::new('description', 'description de l\'évenement')->setRequired(true),
            ImageField::new('imageFichier', 'ajouter une image')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions(['allow_delete' => false])
                ->onlyOnForms()
                ->setRequired(true),
            ImageField::new('image', 'image')
                ->setBasePath($this->getParameter('app.path.featured_evenement_images'))
                ->hideOnForm()
                ->setRequired(true),
            ImageField::new('vignetteFichier', 'ajouter une vignette')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions(['allow_delete' => false])
                ->onlyOnForms()
                ->setRequired(true),
            ImageField::new('vignette', 'vignette')
                ->setBasePath($this->getParameter('app.path.featured_evenement_vignettes'))
                ->hideOnForm()
                ->setRequired(true),
            DateField::new('debuterLe', 'début de l\'évenement')->setRequired(true),
            DateField::new('finirLe', 'fin de l\'évenement')->setRequired(true),
            DateField::new('creerLe', 'date création')->hideOnForm(),
            DateField::new('modifierLe', 'date modification')->hideOnForm(),
            NumberField::new('nombrePlaces', 'nombre de place')->setRequired(true),
            BooleanField::new('actif', 'actif')->renderAsSwitch(),
            AssociationField::new('type')->setRequired(true),
            AssociationField::new('sport')->setRequired(true),
            AssociationField::new('categorie')->setRequired(true),
        ];
    }

}
