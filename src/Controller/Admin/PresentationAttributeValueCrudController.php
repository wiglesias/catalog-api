<?php

namespace App\Controller\Admin;

use App\Entity\PresentationAttributeValue;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PresentationAttributeValueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PresentationAttributeValue::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Attribute Value')
            ->setEntityLabelInPlural('Attribute Values')
            ->setSearchFields(['value']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('product')
            ->setRequired(true)
            ->setCrudController(CatalogPresentationCrudController::class)
            ->autocomplete();
        yield AssociationField::new('attribute')
            ->setRequired(true)
            ->setCrudController(PresentationAttributeCrudController::class)
            ->autocomplete();
        yield TextField::new('value')
            ->setRequired(false)
            ->setHelp('Value of the attribute for the product');
    }
}
