<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Repository\EvenementRepository;
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

class TypeCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    /**
     * @var EvenementRepository
     */
    private $repoEvent;

    public function __construct(EvenementRepository $repoEvent)
    {
        $this->repoEvent = $repoEvent;
    }

    public static function getEntityFqcn(): string
    {
        return Type::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Type')
            ->setEntityLabelInPlural('Types')
            ->setPageTitle('index', 'Admin - Types')
            ->setPageTitle('edit', 'Admin - Editer Type')
            ->setPageTitle('new', 'Admin - Ajouter Type');
    }

    /**
     * @param SearchDto $searchDto
     * @param EntityDto $entityDto
     * @param FieldCollection $fields
     * @param FilterCollection $filters
     * @return QueryBuilder
     */
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
            TextField::new('nom', 'Nom du type'),
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

        if (get_class($instance) === get_class(new Type())) {
            $this->repoEvent->defautTypeEvenement($instance);
        }
    }
}
