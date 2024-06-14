<?php

namespace App\Form;

use App\Entity\Cars;
use App\Entity\Maintenances;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maintenance_type', TextType::class, [
                'label' => false
            ])
            ->add('provider', TextType::class, [
                'label' => false
            ])
            ->add('date', DateType::class, [
                'label' => false,
                'widget' => 'single_text'
            ])
            ->add('hour', TimeType::class, [
                'label' => false,
                'widget' => 'choice',
                'with_minutes' => false,
                'with_seconds' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Ajouter",
                'attr' => [
                    'class' => 'ui teal button'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maintenances::class,
        ]);
    }
}
