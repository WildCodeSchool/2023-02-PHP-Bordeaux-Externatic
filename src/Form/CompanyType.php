<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'attr' => [
                    'placeholder' => 'Entre le nom de l\'entreprise',
                    'class' => 'form-control be-form-input'
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Entre la ville de l\'entreprise',
                    'class' => 'form-control be-form-input'
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Entre le numéro de téléphone de l\'entreprise',
                    'class' => 'form-control be-form-input'
                ],
            ])
            ->add('logo', FileType::class, [
                'label' => 'Logo',
                'attr' => [
                    'class' => 'form-control be-form-input'
                ],
                'mapped' => false,
                'required' => false,
            ])
            ->add('siret', NumberType::class, [
                'label' => 'Numéro Siret',
                'attr' => [
                    'placeholder' => 'Entre le numéro siret de l\'entreprise',
                    'class' => 'form-control be-form-input'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
