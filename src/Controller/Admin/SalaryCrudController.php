<?php

namespace App\Controller\Admin;

use App\Entity\Salary;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class SalaryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Salary::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Salaires')
            ->showEntityActionsInlined();
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            MoneyField::new('min', 'minimum')->setCurrency('EUR'),
            MoneyField::new('max', 'maximum')->setCurrency('EUR'),
        ];
    }
}
