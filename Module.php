<?php

namespace SpeckCatalog;

use Zend\ModuleManager\ModuleManager,
    Zend\Navigation,
    Application\Extra\Page,
    Service\Installer;

class Module
{
    protected $view;
    protected $viewListener;

    public function init(ModuleManager $moduleManager)
    {
        $events       = $moduleManager->events();
        $sharedEvents = $events->getSharedManager();
        $moduleManager->events()->attach('install', array($this, 'preInstall'));
        $moduleManager->events()->attach('install', array($this, 'install'));
        $moduleManager->events()->attach('navigation', array($this, 'navigation'));
    }

    public function getAutoloaderConfig()
    {
        return array(
            //'Zend\Loader\ClassMapAutoloader' => array(
            //    __DIR__ . '/autoload_classmap.php',
            //),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'CatalogManager' => __DIR__ . '/src/CatalogManager',
                    'Catalog' => __DIR__ . '/src/Catalog',
                ),
            ),
        );
    }

    public function preInstall($e)
    {
        //all info needed to configure/update/install this module('SpeckCatalog') will be returned
        return "SpeckCatalog";
    }

    public function install($e)
    {
        echo $e->getParam('locator')->get('catalog_install')->install();
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAssetPath()
    {
        return __DIR__ . '/public';
    }

    public function onBootstrap($e)
    {
        $app          = $e->getParam('application');
        $locator      = $app->getServiceManager();
        $renderer     = $locator->get('Zend\View\Renderer\PhpRenderer');
        $renderer->plugin('url')->setRouter($locator->get('Router'));
        $renderer->plugin('headScript')->appendFile('/js/jquery.js');
        $renderer->plugin('headScript')->appendFile('/js/jquery-ui.js');
        $renderer->plugin('headScript')->appendFile('/js/catalogmanager.js');
        $renderer->plugin('headScript')->appendFile('/js/bootstrap-dropdown.js');
        $renderer->plugin('headScript')->appendFile('/js/bootstrap-modal.js');
        $renderer->plugin('headScript')->appendFile('/js/bootstrap-scrollspy.js');
        $renderer->plugin('headScript')->appendFile('/js/bootstrap-tab.js');
        $renderer->plugin('headLink')->appendStylesheet('/css/catman.css');
    }

    public function navigation($e)
    {
        $catMgr = new Page(array('title' => 'Catalog Manager <b class="caret"></b>'));
        $catMgr->setAttributes(array(
            'wrap' => array('class' => 'dropdown'),
            'page' => array('href' =>'#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
            'container' => array('class'=>'dropdown-menu'),
        ));

        $home = new Page();
        $home->setTitle('<b>Home</b>')->setUrl('/catalogmanager');
        $divider = new Page(array('pageTag'=>false));
        $divider ->setAttributes(array(
            'wrap' => array('class' => 'divider'),
        ));
        $products = new Page();
        $products->setTitle('<b>Products</b>')->setUrl('/catalogmanager/products');
        $productItem = new Page();
        $productItem->setTitle('+ New Product (item)')->setUrl('/catalogmanager/new/product/item');
        $productShell = new Page();
        $productShell->setTitle(' + New Product (shell)')->setUrl('/catalogmanager/new/product/shell');
        $categories = new Page();
        $categories->setTitle('<b>Categories</b>')->setUrl('/catalogmanager/categories');
        $catMgr->addPages(array(
            $home,
            $divider, 
            $products,
            $productItem, 
            $productShell,
            $divider,
            $categories,
        ));

        $sites = new Page(array('title' => 'Site <b class="caret"></b>'));
        $sites->setAttributes(array(
            'wrap' => array('class' => 'dropdown'),
            'page' => array('href' =>'#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
            'container' => array('class'=>'dropdown-menu'),
        ));

        $e->getTarget()->addPage($catMgr);
        $e->getTarget()->addPage($sites);
    }

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'catalog_generic_service' => function ($sm) {
                    return new \Catalog\Service\CatalogService;
                },
                'catalog_product_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\ProductService;
                    $service->setModelMapper($di->get('catalog_product_mapper'));
                    return $service;
                },
                'catalog_option_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\OptionService;
                    $service->setModelMapper($di->get('catalog_option_mapper'));
                    return $service;
                },
                'catalog_model_linker_service' => function ($sm) {
                    $service = new \Catalog\Service\ModelLinkerService;
                    return $service;
                },
                'catalog_image_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\ImageService;
                    $service->setModelMapper($di->get('catalog_image_mapper'));
                    return $service;
                },
                'catalog_document_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\DocumentService;
                    $service->setModelMapper($di->get('catalog_document_mapper'));
                    return $service;
                },
                'catalog_category_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\CategoryService;
                    $service->setModelMapper($di->get('catalog_category_mapper'));
                    return $service;
                },
                'catalog_choice_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\ChoiceService;
                    $service->setModelMapper($di->get('catalog_choice_mapper'));
                    return $service;
                },
                'catalog_product_uom_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\ProductUomService;
                    $service->setModelMapper($di->get('catalog_product_uom_mapper'));
                    return $service;
                }, 
                'catalog_uom_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\UomService;
                    $service->setModelMapper($di->get('catalog_uom_mapper'));
                    return $service;
                },             
                'catalog_availability_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\AvailabilityService;
                    $service->setModelMapper($di->get('catalog_availability_mapper'));
                    return $service;
                },             
                'catalog_company_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\CompanyService;
                    $service->setModelMapper($di->get('catalog_company_mapper'));
                    return $service;
                },             
                'catalog_spec_service' => function ($sm) {
                    $di = $sm->get('Di');
                    $service = new \Catalog\Service\SpecService;
                    $service->setModelMapper($di->get('catalog_spec_mapper'));
                    return $service;
                },             

            ),
        );

    }

}
