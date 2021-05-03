<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Repository\EvenementRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategorieCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    /**
     * @var EvenementRepository
     */
    private $repoEvent;
    /**
     * @var UtilisateurRepository
     */
    private $repoUtilisateur;

    public function __construct(EvenementRepository $repoEvent, UtilisateurRepository $repoUtilisateur)
    {
        $this->repoEvent = $repoEvent;
        $this->repoUtilisateur = $repoUtilisateur;
    }

    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories')
            ->setPageTitle('index', 'Admin - Catégories')
            ->setPageTitle('edit', 'Admin - Editer Catégorie')
            ->setPageTitle('new', 'Admin - Ajouter Catégorie');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where("entity.nom != 'Autre'");

        return $response;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom de la catégorie'),
            TextField::new('color', 'Nom de la couleur'),
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'eventDelete',
            BeforeEntityDeletedEvent::class => 'eventDelete'
        ];
    }

    /**
     * @param $event
     * @internal
     */
    public function eventDelete($event)
    {
        $instance = $event->getEntityInstance();

        if (ClassUtils::getClass($instance) === get_class(new Categorie())) {
            $this->repoEvent->defautCategEvenement($instance);
            $this->repoUtilisateur->defautCategUtilisateur($instance);
        }
    }
}
