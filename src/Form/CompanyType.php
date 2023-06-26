<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;
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
                    'class' => 'form-control be-form-input mb-3'
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Entre la ville de l\'entreprise',
                    'class' => 'form-control be-form-input mb-3'
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '0123456789',
                    'class' => 'form-control be-form-input mb-3'
                ],
            ])
            ->add('logoFile', VichFileType::class, [
                'label' => 'Logo',
                'required'      => false,
                'allow_delete'  => true,
                'download_uri' => true,
                'attr' => [
                    'class' => 'form-control be-form-input mb-3'
                ],
            ])
            ->add('siret', NumberType::class, [
                'label' => 'Numéro Siret',
                'attr' => [
                    'placeholder' => 'Entre le numéro siret',
                    'class' => 'form-control be-form-input mb-3'
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
