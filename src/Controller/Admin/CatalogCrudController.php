<?php

namespace App\Controller\Admin;

use App\Entity\Catalog;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CatalogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Catalog::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('customer');
        yield TextField::new('name');
        yield BooleanField::new('active');
    }
}
