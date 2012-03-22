<?php

namespace SpeckCatalog;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    Zend\Navigation,
    Application\Extra\Page,
    Service\Installer;

class Module implements AutoloaderProvider
{
    protected $view;
    protected $viewListener;

    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'initializeView'), 100);
        $moduleManager->events()->attach('install', array($this, 'preInstall'));
        $moduleManager->events()->attach('install', array($this, 'install'));
        $moduleManager->events()->attach('navigation', array($this, 'navigation'));
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
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

    public function initializeView($e)
    {
        $app          = $e->getParam('application');
        $locator      = $app->getLocator();
        $renderer     = $locator->get('Zend\View\Renderer\PhpRenderer');
        $renderer->plugin('url')->setRouter($app->getRouter());
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
        $newCategory = new Page();
        $newCategory->setTitle(' + New Category')->setUrl('/catalogmanager/new/category');
        $catMgr->addPages(array(
            $home,
            $divider, 
            $products,
            $productItem, 
            $productShell,
            $divider,
            $categories,
            $newCategory,
        ));

        $e->getTarget()->addPage($catMgr);
    }

}
