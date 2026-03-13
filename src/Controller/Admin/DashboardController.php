<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Catalog;
use App\Entity\CatalogPresentation;
use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Catalog Manager');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Clientes');
        yield MenuItem::linkTo(CustomerCrudController::class, 'Cliente', 'fa fa-building' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkTo(CatalogCrudController::class, 'Catálogo', 'fa fa-book' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::section('Presentaciones');
        yield MenuItem::linkTo(CatalogPresentationCrudController::class, 'Producto', 'fa fa-box' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkTo(CatalogPresentationComponentCrudController::class, 'Componentes', 'fa fa-list' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::section('Artículos');
        yield MenuItem::linkTo(ArticleCrudController::class, 'Artículo', 'fa fa-cube' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::section('Atributos');
        yield MenuItem::linkTo(PresentationAttributeCrudController::class, 'Atributos de presentación', 'fa fa-tags')->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkTo(PresentationAttributeValueCrudController::class, 'Valores de los atributos', 'fa fa-list-alt')->setAction(Crud::PAGE_INDEX);
        yield MenuItem::section('Catalog Categorías');
        yield MenuItem::linkTo(CatalogCategoryCrudController::class,'Categoría', 'fa fa-tags');
    }
}
