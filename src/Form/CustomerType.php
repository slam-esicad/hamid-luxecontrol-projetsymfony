<?php

namespace App\Form;

use App\Entity\Customers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false
            ])
            ->add('address', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('pc', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('city', TextType::class, [
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
            ->add('pro', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'type' => 'checkbox',
                    'class' => 'ui checkbox'
                ]
            ])
            ->add('siret', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('rib', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('bic', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('website', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('sub_customer', SubmitType::class, [
                'attr' => ['class' => 'ui teal button']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customers::class,
        ]);
    }
}
