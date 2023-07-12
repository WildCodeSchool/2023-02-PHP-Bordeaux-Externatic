<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addCssFile('admin-style/admin-style.css');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Entreprises')
            ->showEntityActionsInlined()
            ->setEntityLabelInSingular('entreprise')
            ->setEntityLabelInPlural('entreprises');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'nom'),
            TextField::new('city', 'ville'),
            TelephoneField::new('phone', 'téléphone'),
            TextField::new('logo', 'logo')->hideOnForm(),
            TextField::new('siret', 'SIRET'),
            AssociationField::new('user', 'utilisateur associé')
        ];
    }
}
