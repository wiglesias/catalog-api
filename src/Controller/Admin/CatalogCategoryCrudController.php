<?php

namespace App\Controller\Admin;

use App\Entity\CatalogCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CatalogCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CatalogCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('catalog'),
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            AssociationField::new('parent')
                ->autocomplete()
                ->setFormTypeOptions([
                'required' => false,
            ]),
            BooleanField::new('active'),
        ];
    }
}
