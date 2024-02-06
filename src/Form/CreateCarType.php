<?php

namespace App\Form;

use App\Entity\Cars;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CreateCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', ChoiceType::class, [
                'choices' => [
                    'Renault' => 'Renault',
                    'Ouais' => 'ouais',
                    'non' => 'non'
                ],
                'label' => false,
                'attr' => [
                    'class' => 'ui dropdown'
                ]
            ])
            /*->add('brand', TextType::class, [
                'label' => false
            ])*/
            ->add('model', TextType::class, [
                'label' => false
            ])
            ->add('img', FileType::class, [
                'label' => false,
                'data_class' => null,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpg',
                            'image/webp',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => "Veuillez sélectionner le bon type de fichier"
                    ])
                ]
            ])
            ->add('km', IntegerType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('reg_number', TextType::class, [
                'label' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('energy', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('tank', IntegerType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('horsepower', IntegerType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('gearbox', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('doors', IntegerType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('dayprice', IntegerType::class, [
                'label' => false,
                'attr' => ['value' => 0]
            ])
            ->add('buyprice', IntegerType::class, [
                'label' => false,
                'attr' => ['value' => 0]
            ])
            ->add('year', IntegerType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('color', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('sub_car', SubmitType::class, [
                'attr' => ['class' => 'ui teal button']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cars::class,
            'constraints' => [
                new UniqueEntity([
                    'fields' => 'reg_number'
                ],
                "La plaque d'immatriculation doit être unique sur chaque voiture")
            ],
        ]);
    }
}
