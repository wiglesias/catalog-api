<?php

namespace App\Controller\Admin;

use App\Entity\CatalogPresentation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
        yield TextField::new('code');
        yield TextField::new('name');
        yield AssociationField::new('customer');
        yield AssociationField::new('catalog');
        yield CollectionField::new('components')
            ->useEntryCrudForm()
            ->setEntryIsComplex(true)
            ->allowAdd()
            ->allowDelete()
        ;
    }
}
