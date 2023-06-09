<?php

namespace App\Form;

use App\Entity\Resume;
use App\Entity\User;
use App\Repository\ResumeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class JobofferApplyType extends AbstractType
{
    private TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $this->token->getToken()->getUser();
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entre ton prénom',
                    'class' => 'form-control mb-md-5 mb-3 be-form-input' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entre ton nom',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' // Ajoute une classe CSS personnalisée
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'exemple.email@gmail.com',
                    'class' => 'form-control be-form-input mb-md-5 mb-3' // Ajoute une classe CSS personnalisée
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
                    'class' => 'form-control be-form-input form-group mb-md-5 mb-3 h-auto'
                ],
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('r')
                        ->where('r.user = :user')
                        ->setParameter('user', $user);
                },
            ]);
    }




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
