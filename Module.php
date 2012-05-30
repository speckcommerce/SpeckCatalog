<?php

namespace SpeckCatalog;

use Zend\ModuleManager\ModuleManager,
    Zend\Navigation,
    Application\Extra\Page,
    Service\Installer,
    Catalog\Model\Mapper;

class Module
{
    protected $view;
    protected $viewListener;

    public function init(ModuleManager $moduleManager)
    {
        $events       = $moduleManager->events();
        $sharedEvents = $events->getSharedManager();
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
            'invokables' => array(
                'catalog_generic_service' => 'Catalog\Service\CatalogService',
                'catalog_model_linker_service' => 'Catalog\Service\ModelLinkerService',
                'catalog_product_service' => 'Catalog\Service\ProductService',
                'catalog_option_service' => 'Catalog\Service\OptionService',
                'catalog_image_service' => 'Catalog\Service\ImageService',
                'catalog_document_service' => 'Catalog\Service\DocumentService',
                'catalog_category_service' => 'Catalog\Service\CategoryService',
                'catalog_choice_service' => 'Catalog\Service\ChoiceService',
                'catalog_product_uom_service' => 'Catalog\Service\ProductUomService',
                'catalog_uom_service' => 'Catalog\Service\UomService',
                'catalog_availability_service' => 'Catalog\Service\AvailabilityService',
                'catalog_company_service' => 'Catalog\Service\CompanyService',
                'catalog_spec_service' => 'Catalog\Service\SpecService',
                'table_gateway' => 'Catalog\Model\Mapper\TableGateway',
            ),
            'factories' => array(

                'catalog_product_mapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tg = new Mapper\TableGateway('catalog_product', $adapter);
                    $mapper = new Mapper\ProductMapper($tg);
                    return $mapper;
                },
                'catalog_option_mapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tg = new Mapper\TableGateway('catalog_option', $adapter);
                    $mapper = new Mapper\OptionMapper($tg);   
                    return $mapper;
                    //$mapper->setParentProductLinkerTable($di->get('catalog_product_option_linker_tg'));
                    //$mapper->setParentChoiceLinkerTable($di->get('catalog_choice_option_linker_tg'));
                },
                'catalog_category_mapper' => function ($sm) {
                    $di = $sm->get('Di');
                    $mapper = new \Catalog\Model\Mapper\CategoryMapper;
                    $mapper->setTableGateway($di->get('catalog_category_tg'));
                    return $mapper;             
                },
                'catalog_choice_mapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tg = new Mapper\TableGateway('catalog_choice', $adapter);
                    $mapper = new Mapper\ChoiceMapper($tg);   
                    return $mapper;  
                    //$mapper->setParentOptionLinkerTable($di->get('catalog_option_choice_linker_tg'));
                    //$mapper->setChildOptionLinkerTable($di->get('catalog_choice_option_linker_tg'));
                },    
                'catalog_product_uom_mapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tg = new Mapper\TableGateway('catalog_product_uom', $adapter);
                    $mapper = new Mapper\ProductUomMapper($tg);   
                    return $mapper; 
                },                       
                'catalog_company_mapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tg = new Mapper\TableGateway('catalog_company', $adapter);
                    $mapper = new Mapper\CompanyMapper($tg);   
                    return $mapper; 
                },   
                'catalog_spec_mapper' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tg = new Mapper\TableGateway('catalog_product_spec', $adapter);
                    $mapper = new Mapper\SpecMapper($tg);   
                    return $mapper; 
                },   

            ),
        );

    }

}
