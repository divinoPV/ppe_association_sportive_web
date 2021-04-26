<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use App\Repository\CategorieRepository;
use App\Repository\SportRepository;
use App\Repository\TypeRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EvenementCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    private TypeRepository $repoType;
    /**
     * @var SportRepository
     */
    private SportRepository $repoSport;
    /**
     * @var CategorieRepository
     */
    private CategorieRepository $repoCateg;

    public function __construct(TypeRepository $repoType, SportRepository $repoSport, CategorieRepository $repoCateg)
    {
        $this->repoType = $repoType;
        $this->repoSport = $repoSport;
        $this->repoCateg = $repoCateg;
    }

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
                ->setFormTypeOptions([
                    'allow_delete' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg',
                            ],
                            'mimeTypesMessage' => 'Votre fichier doit-être du format suivant: png, jpg ou jpeg',
                        ])
                    ],
                ])
                ->onlyOnForms(),
            ImageField::new('image', 'image')
                ->setBasePath($this->getParameter('app.path.featured_evenement_images'))
                ->setRequired(true)
                ->hideOnForm(),
            ImageField::new('vignetteFichier', 'ajouter une vignette')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions([
                    'allow_delete' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg',
                            ],
                            'mimeTypesMessage' => 'Votre fichier doit-être du format suivant: png, jpg ou jpeg',
                        ])
                    ],
                ])
                ->onlyOnForms(),
            ImageField::new('vignette', 'vignette')
                ->setBasePath($this->getParameter('app.path.featured_evenement_vignettes'))
                ->setRequired(true)
                ->hideOnForm(),
            DateField::new('debuterLe', 'début de l\'évenement')->setRequired(true),
            DateField::new('finirLe', 'fin de l\'évenement')->setRequired(true),
            NumberField::new('nombrePlaces', 'nombre de place')->setRequired(true),
            BooleanField::new('actif', 'actif')->renderAsSwitch(),
            AssociationField::new('type')
                ->setRequired(true)
                ->setFormTypeOptions(['empty_data' => $this->repoType->findOneBy([
                    "nom" => 'Autre'
                ])]),
            AssociationField::new('sport')
                ->setRequired(true)
                ->setFormTypeOptions(['empty_data' => $this->repoSport->findOneBy([
                    "nom" => 'Autre'
                ])]),
            AssociationField::new('categorie')
                ->setRequired(true)
                ->setFormTypeOptions(['empty_data' => $this->repoCateg->findOneBy([
                    "nom" => 'Autre'
                ])]),
        ];
    }
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'eventDelete',
        ];
    }

    /**
     * @param $event
     * @internal
     */
    public function eventDelete($event)
    {
        $instance = $event->getEntityInstance();

        if (get_class($instance) === get_class(new Evenement())) {
            if ((!empty($instance->getVignette()) && $instance->getVignette() !== null)
                && (!empty($instance->getImage()) && $instance->getImage() !== null)) {
                dd($instance);
            }else {
                $this->addFlash('info', 'test');
            }
        }
    }
}
