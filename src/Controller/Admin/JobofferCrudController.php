<?php

namespace App\Controller\Admin;

use App\Entity\Joboffer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class JobofferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Joboffer::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
