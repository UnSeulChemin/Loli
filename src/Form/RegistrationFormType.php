<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, options:[
                'attr' => [
                    'minlength' => '5',
                    'maxlength' => '30',
                    'autofocus' => null
                ],
                'label' => 'Email'
            ])
            ->add('name', TextType::class, options:[
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '10'
                ],
                'label' => 'Name'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'minlength' => '5',
                    'maxlength' => '10'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Password field can\'t be empty.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max'=> 30,
                        'minMessage' => 'Password shoud have at least {{ limit }} characters.',
                        'maxMessage' => 'Password shoud have no more than {{ limit }} characters.'
                    ]),
                ],
                'label' => 'Password'
            ])
            ->add('submit', SubmitType::class, options:[
                'label' => 'Register',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['id' => 'register']
        ]);
    }
}
