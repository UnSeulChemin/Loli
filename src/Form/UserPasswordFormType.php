<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'minlength' => '5',
                    'maxlength' => '30',
                    'autofocus' => null
                ],
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{5,}$/',
                    "Password should have at least 5 characters, 1 uppercase, 1 lowercase, 1 digit, 1 special character")
                ],
                'label' => 'New password'
            ])
            ->add('submit', SubmitType::class, options:[
                'attr' => [
                    'class' => 'margin-bottom-none'
                ],
                'label' => 'Comfirm',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['id' => 'profil_password']
        ]);
    }
}