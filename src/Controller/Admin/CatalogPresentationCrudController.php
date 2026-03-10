<?php

namespace App\Controller\Admin;

use App\Entity\CatalogPresentation;
use App\Form\PresentationAttributeValueType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CatalogPresentationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CatalogPresentation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('presentation')
            ->setEntityLabelInPlural('presentations')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(6);
        yield TextField::new('code');
        yield TextField::new('name');
        yield AssociationField::new('customer');
        yield AssociationField::new('catalog')
            ->autocomplete();
        yield AssociationField::new('category')
            ->autocomplete();
        yield CollectionField::new('components')
            ->useEntryCrudForm()
            ->setEntryIsComplex(true)
            ->allowAdd()
            ->allowDelete()
        ;
        yield FormField::addColumn(6);
        yield CollectionField::new('attributeValues')
            ->setEntryType(PresentationAttributeValueType::class)
            ->allowAdd()
            ->allowDelete()
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            ->setLabel('Attribute')
        ;
        yield BooleanField::new('active');
    }
}
