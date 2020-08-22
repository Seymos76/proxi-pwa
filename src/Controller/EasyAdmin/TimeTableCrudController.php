<?php

namespace App\Controller\EasyAdmin;

use App\Entity\TimeTable;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class TimeTableCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TimeTable::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ArrayField::new('days'),
            TimeField::new('openingTime'),
            TimeField::new('closingTime'),
        ];
    }
}
