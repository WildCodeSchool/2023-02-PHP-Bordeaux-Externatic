<?php

namespace App\Form;

use App\Entity\Resume;
use App\Entity\User;
use App\Repository\ResumeRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;

class JobofferApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entre ton prénom',
                    'class' => 'form-control mb-5 be-form-input' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entre ton nom',
                    'class' => 'form-control be-form-input mb-5' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'exemple.email@gmail.com',
                    'class' => 'form-control be-form-input mb-5' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('resumes', EntityType::class, [
                'class' => Resume::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'placeholder' => 'Choisissez un CV',
                'label' => 'Choisissez un de vos CV',
                'constraints' => [
                    new Count([
                        'max' => 1,
                        'maxMessage' => 'Veuillez choisir un seul CV'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control be-form-input form-group mb-5 h-auto'
                ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
