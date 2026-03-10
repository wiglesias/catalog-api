<?php

namespace App\Controller\Admin;

use App\Entity\CatalogPresentationComponent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CatalogPresentationComponentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CatalogPresentationComponent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('article')->autocomplete();
        yield NumberField::new('quantity');
        yield TextField::new('unit');
        yield IntegerField::new('position');
    }
}
