<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Configurator\TelephoneConfigurator;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addCssFile('admin-style/admin-style.css');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Utilisateurs')
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('utilisateur')
            ->setEntityLabelInPlural('utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'identifiant')->hideOnForm(),
            EmailField::new('email', 'e-mail'),
            ChoiceField::new('roles', 'rôle')->setChoices([
                'utilisateur' => 'ROLE_USER',
                'administrateur' => 'ROLE_ADMIN'
            ])->allowMultipleChoices(),
            TextField::new('firstname', 'prénom'),
            TextField::new('lastname', 'nom de famille'),
            DateTimeField::new('birthday', 'date de naissance'),
            TextField::new('city', 'ville'),
            TelephoneField::new('phone', 'numéro de téléphone'),
            DateTimeField::new('createdAt', 'date de création')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt', 'date de modification')->hideOnForm()->hideOnIndex(),
            BooleanField::new('isVerified', 'vérifié ou non')
        ];
    }
}
