<?php

namespace App\Form;

use App\Entity\ContactsCustomers;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sub', SubmitType::class, [
                'attr' => ['class' => 'ui clr_bg button']
            ])
            ->add('firstname', TextType::class, [
                'label' => false
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('function', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactsCustomers::class,
        ]);
    }
}
