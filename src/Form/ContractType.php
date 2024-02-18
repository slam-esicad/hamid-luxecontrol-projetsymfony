<?php

namespace App\Form;

use App\Entity\Cars;
use App\Entity\Contracts;
use App\Entity\Customers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('status', ChoiceType::class, [
                'placeholder' => false,
                'choices' => ['En cours' => 0, "Terminé" => 1],
                'expanded' => true,
                'multiple' => false,
                'label' => false,
                'required' => false
            ])
            ->add('startdate', DateType::class, [
                'widget' => 'single_text',
                'label' => false
            ])
            ->add('enddate', DateType::class, [
                'widget' => 'single_text',
                'label' => false
            ])
            ->add('price', IntegerType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Vente' => 0,
                    'Location' => 1
                ],
                'label' => false,
                'required' => false
            ])
            ->add('customer', EntityType::class, [
                'class' => Customers::class,
                'choice_label' => 'name',
                'label' => false
            ])
            ->add('car', EntityType::class, [
                'class' => Cars::class,
                'choice_label' => function(Cars $cars) {
                    return $cars->getBrand()->getName() . ' ' . $cars->getModel();
                },
                'label' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'ui teal button'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contracts::class,
        ]);
    }
}
