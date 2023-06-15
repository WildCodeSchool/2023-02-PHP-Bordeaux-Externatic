<?php

namespace App\Form;

use App\Entity\Joboffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobofferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('city')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('company')
            ->add('job')
            ->add('contract')
            ->add('salary')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joboffer::class,
        ]);
    }
}
