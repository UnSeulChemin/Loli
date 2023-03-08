<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, options:[
                'attr' => [
                    'minlength' => '2',
                    'maxlength' => '10'
                ],
                'label' => 'Name'
            ])
            ->add('email', EmailType::class, options:[
                'attr' => [
                    'minlength' => '5',
                    'maxlength' => '30'
                ],
                'label' => 'Email'
            ])
            ->add('subject', TextType::class, options:[
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '30'
                ],
                'label' => 'Subject'
            ])
            ->add('message', TextType::class, options:[
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '500'
                ],
                'label' => 'Message'
            ])
            ->add('submit', SubmitType::class, options:[
                'label' => 'Submit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
