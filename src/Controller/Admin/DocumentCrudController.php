<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DocumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Document')
            ->setEntityLabelInPlural('Documents')
            ->setPageTitle('index', 'Admin - Documents')
            ->setPageTitle('edit', 'Admin - Editer Document')
            ->setPageTitle('new', 'Admin - Ajouter Document');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnform(),
            TextField::new('nom'),
            TextField::new('lien'),
            TextField::new('description'),
            AssociationField::new('categorie')->autocomplete()
        ];
    }

}
