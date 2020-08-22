<?php

namespace App\Controller\EasyAdmin;

use App\Entity\BusinessCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BusinessCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BusinessCategory::class;
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
