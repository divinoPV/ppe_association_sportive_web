<?php

namespace App\Controller\Admin;

use App\Entity\DocumentCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DocumentCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DocumentCategorie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Document catégorie')
            ->setEntityLabelInPlural('Document catégories')
            ->setPageTitle('index', 'Admin - Document catégories')
            ->setPageTitle('edit', 'Admin - Editer Document catégorie')
            ->setPageTitle('new', 'Admin - Ajouter Document catégorie');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),

        ];
    }

}
