<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Enum\ArticleType;
use App\Enum\UnitType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(6, 'General');
        yield TextField::new('code', 'Código');
        yield TextField::new('name', 'Nombre');
        yield ChoiceField::new('unit', 'Unidad')
            ->setChoices(UnitType::cases())
            ->setFormTypeOption('choice_label', fn(UnitType $unit) => $unit->label())
            ->renderAsBadges()
            ->formatValue(fn (?UnitType $unit) => $unit?->label());
        yield ChoiceField::new('type', 'Tipo de artículo')
            ->setChoices(ArticleType::cases())
            ->setFormTypeOption('choice_label', fn(ArticleType $type) => $type->label())
            ->renderAsBadges([
                'raw_material' => 'warning',
                'packaging' => 'info',
                'component' => 'secondary',
                'label' => 'primary',
                'shipping_material' => 'dark',
                'finished_product' => 'success',
            ])
            ->formatValue(fn (?ArticleType $type) => $type?->label());

        yield TextField::new('barcode','Código de barras')->hideOnIndex();
        yield BooleanField::new('active', 'Activo');
        yield FormField::addColumn(6, 'Stock');
        yield NumberField::new('netWeight','Peso neto')
            ->setNumDecimals(4)
            ->hideOnIndex();
        yield NumberField::new('grossWeight','Peso bruto')
            ->setNumDecimals(4)
            ->hideOnIndex();
        yield NumberField::new('length','Largo')
            ->hideOnIndex();
        yield NumberField::new('width','Ancho')
            ->hideOnIndex();
        yield NumberField::new('height','Alto')
            ->hideOnIndex();
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->add(Crud::PAGE_DETAIL, Action::DETAIL);
    }
}
