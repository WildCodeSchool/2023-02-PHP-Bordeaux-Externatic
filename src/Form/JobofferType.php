<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\Job;
use App\Entity\Joboffer;
use App\Entity\Salary;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobofferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Entre le titre de l\'offre',
                    'class' => 'form-control mb-md-5 mb-3 be-form-input' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Entre la description de l\'offre',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Entre la ville de l\'offre',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez un métier',
                'label' => 'Choisissez un métier',
                'attr' => [
                    'class' => 'form-control be-form-input form-group mb-md-5 mb-3 h-auto'
                ]
            ])
            ->add('contract', EntityType::class, [
                'class' => Contract::class,
                'choice_label' => 'type',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez un contrat',
                'label' => 'Choisissez un contrat',
                'attr' => [
                    'class' => 'form-control be-form-input form-group mb-md-5 mb-3 h-auto'
                ]
            ])
            ->add('salary', EntityType::class, [
                'class' => Salary::class,
                'choice_label' => 'min',
                'multiple' => false,
                'expanded' => false,
                'label' => 'Salaire minimal',
                'attr' => [
                    'placeholder' => 'Entre le salaire minimal de l\'offre',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' // Ajoute une classe CSS personnalisée
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joboffer::class,
        ]);
    }
}
