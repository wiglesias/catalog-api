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
//        return parent::index();
//
//        // Option 1. You can make your dashboard redirect to some common page of your backend
//        //
//        // return $this->redirectToRoute('admin_user_index');
//
//        // Option 2. You can make your dashboard redirect to different pages depending on the user
//        //
//        // if ('jane' === $this->getUser()->getUsername()) {
//        //     return $this->redirectToRoute('...');
//        // }
//
//        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
//        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
//        //
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
        yield MenuItem::section('Customers');
        yield MenuItem::linkTo(CustomerCrudController::class, 'Customers', 'fa fa-building' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkTo(CatalogCrudController::class, 'Catalogs', 'fa fa-book' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::section('Products');
        yield MenuItem::linkTo(CatalogPresentationCrudController::class, 'Products', 'fa fa-box' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkTo(CatalogPresentationComponentCrudController::class, 'Components', 'fa fa-list' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::section('Articles');
        yield MenuItem::linkTo(ArticleCrudController::class, 'Articles', 'fa fa-cube' )->setAction(Crud::PAGE_INDEX);
        yield MenuItem::section('Attributes');
        yield MenuItem::linkTo(PresentationAttributeCrudController::class, 'Presentation Attributes', 'fa fa-tags')->setAction(Crud::PAGE_INDEX);
        yield MenuItem::linkTo(PresentationAttributeValueCrudController::class, 'Attribute Values', 'fa fa-list-alt')->setAction(Crud::PAGE_INDEX);
    }
}
