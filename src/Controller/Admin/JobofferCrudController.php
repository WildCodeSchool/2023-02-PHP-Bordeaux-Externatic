<?php

namespace App\Controller\Admin;

use App\Entity\Joboffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobofferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Joboffer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Offres d\'emploi')
            ->showEntityActionsInlined();
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'titre'),
            TextEditorField::new('description'),
            TextField::new('city', 'ville'),
            AssociationField::new('contract', 'contrat'),
            DateTimeField::new('createdAt', 'date de création')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updatedAt', 'date de modification')->hideOnForm()->hideOnIndex(),
            AssociationField::new('job', 'emploi'),
            AssociationField::new('company', 'entreprise'),
            AssociationField::new('salary', 'salaire min-max')
            ];
    }
}
