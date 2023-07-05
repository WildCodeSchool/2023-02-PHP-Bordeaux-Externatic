<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Contract;
use App\Entity\Job;
use App\Entity\Joboffer;
use App\Entity\Salary;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobofferType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Entre le titre de l\'offre',
                    'class' => 'form-control mb-md-5 mb-3 be-form-input' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Entre la description de l\'offre',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' ,
                    'rows' => 15,// Ajoute une classe CSS personnalisée
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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('j')
                        ->orderBy('j.name', 'ASC'); // Tri par ordre alphabétique sur le champ 'name'
                },
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez un métier',
                'label' => 'Métier',
                'attr' => [
                    'class' => 'form-control be-form-input form-group mb-md-5 mb-3 h-auto'
                ]
            ])
            ->add('contract', EntityType::class, [
                'class' => Contract::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                    ->orderBy('c.type', 'ASC');
                },
                'choice_label' => 'type',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez un contrat',
                'label' => 'Type de contrat',
                'attr' => [
                    'class' => 'form-control be-form-input form-group mb-md-5 mb-3 h-auto'
                ]
            ])
            ->add('salaryMin', NumberType::class, [
                'label' => 'Salaire minimal',
                'attr' => [
                    'placeholder' => '20000',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('salaryMax', NumberType::class, [
                'label' => 'Salaire maximal',
                'attr' => [
                    'placeholder' => '50000',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->setParameter('user', $user);
                },
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisissez une entreprise',
                'label' => 'Entreprise',
                'attr' => [
                    'class' => 'form-control be-form-input form-group mb-md-5 mb-3'
                ]
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
