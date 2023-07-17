<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Contract;
use App\Entity\Job;
use App\Entity\Joboffer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPersonalSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Dans quelle ville ?',
                'required' => false, // Le champ n'est pas obligatoire
                'attr' => [
                    'placeholder' => 'Renseigne une ville',
                    'class' => 'form-control be-form-input mb-md-5 mb-3'
                ],
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'required' => false, // Le champ n'est pas obligatoire
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Dans quelle entreprise ?',
                'placeholder' => 'Choisi une entreprise',
                'attr' => [
                    'class' => 'form-control be-form-input mb-md-5 mb-3 be-input-color'
                ],
            ])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'required' => false, // Le champ n'est pas obligatoire
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('j')
                        ->orderBy('j.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Quel métier ?',
                'placeholder' => 'Choisi un métier',
                'attr' => [
                    'class' => 'form-control be-form-input mb-md-5 mb-3 be-input-color'
                ],
            ])
            ->add('contract', EntityType::class, [
                'class' => Contract::class,
                'required' => false, // Le champ n'est pas obligatoire
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.type', 'ASC');
                },
                'choice_label' => 'type',
                'label' => 'Quel contrat ?',
                'placeholder' => 'Choisi un type de contrat',
                'attr' => [
                    'class' => 'form-control be-form-input mb-md-5 mb-3 be-input-color'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joboffer::class,
        ]);
    }
}
