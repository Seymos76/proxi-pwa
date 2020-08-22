<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Business;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BusinessCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Business::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('address'),
            TelephoneField::new('phoneNumber'),
            AssociationField::new('city'),
            ImageField::new('image')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['name', 'city.name'])
            ->setDefaultSort(['name' => 'ASC'])
            ->setPaginatorPageSize(5)

            ->setFormOptions([
                'data_class' => null
            ])
            ;
    }
}
