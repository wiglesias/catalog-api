<?php

namespace App\Controller\Admin;

use App\Entity\PresentationAttribute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PresentationAttributeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PresentationAttribute::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Attribute')
            ->setEntityLabelInPlural('Attributes')
            ->setSearchFields(['id', 'name', 'code']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('code')->setRequired(true);
        yield TextField::new('name')->setRequired(true);
        yield TextField::new('type')->setRequired(true)
            ->setHelp('Type of the attribute (e.g. string, integer, boolean, date)');
    }
}
