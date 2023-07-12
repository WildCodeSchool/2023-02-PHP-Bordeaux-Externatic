<?php

namespace App\Controller\Admin;

use App\Entity\Resume;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ResumeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Resume::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addCssFile('admin-style/admin-style.css');
    }
    public function configureCrud(Crud $crud): Crud
    {

        return $crud->setPageTitle('index', 'CV')
        ->showEntityActionsInlined()
        ->setEntityLabelInSingular('CV')
        ->setEntityLabelInPlural('CV');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'nom'),
            AssociationField::new('user', 'utilisateur associé'),
            TextField::new('path', 'chemin du fichier')
        ];
    }
}
