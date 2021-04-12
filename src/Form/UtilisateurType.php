<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                'required' => false,
            ])
            ->add('nom',null, [
                'required' => false,
            ])
            ->add('prenom',null, [
                'required' => false,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required' => false,
                'invalid_message' => 'Veuillez indiquer le même mot de passe',
                'type' => PasswordType::class,
                'first_options' => ['label' => 'mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe']
            ])
            ->add('naissance', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('categorie',null, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
