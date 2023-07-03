<?php

namespace App\Form;

use App\Entity\Resume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre CV',
                'attr' => [
                    'class' => 'form-control be-form-input mb-md-5 mb-3', // Ajoute une classe CSS personnalisée
                    'placeholder' => 'CV de développeur web back-end',
                ],
            ])
            ->add('pathFile', VichFileType::class, [
                'label' => 'CV',
                'required'      => false,
                'allow_delete'  => true,
                'download_uri' => true,
                'attr' => [
                    'class' => 'form-control be-form-input mb-3'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resume::class,
        ]);
    }
}
