<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setTimezone('Europe/Paris')
            ->setPageTitle('index', 'Admin - Utilisateurs')
            ->setPageTitle('detail', 'Admin - Détail Utilisateur')
            ->setPageTitle('edit', 'Admin - Editer Utilisateur')
            ->setPageTitle('new', 'Admin - Ajouter Utilisateur');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield FormField::addPanel('Détails de l\'utilisateur'),
            yield IdField::new('id')->hideOnForm(),
            yield EmailField::new('email'),
            yield ArrayField::new('roles'),
            yield TextField::new('plainPassword')
                ->onlyOnForms()
                ->setFormType(PasswordType::class),
            yield BooleanField::new('forgottenPassword'),
            yield FormField::addPanel('Date')->hideOnForm(),
            yield DateTimeField::new('creer')->hideOnForm(),
            yield DateTimeField::new('modifier')->hideOnForm(),
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'encodePassword',
            BeforeEntityUpdatedEvent::class => 'encodePassword',
        ];
    }

    /** @internal */
    public function encodePassword($event)
    {
        $instance= $event->getEntityInstance();
        if (get_class($instance) === get_class(new User())) {
            if ($instance->getPlainPassword()){
                $instance->setPassword($this->passwordEncoder->encodePassword($instance, $instance->getPlainPassword()));
            }
        }
    }
}
