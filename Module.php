<?php

namespace SpeckCatalog;

use Zend\Module\Consumer\AutoloaderProvider,
    Zend\EventManager\StaticEventManager;

class Module implements AutoloaderProvider
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'SpeckCatalog' => __DIR__ . '/src/SpeckCatalog',
                    'SpeckCatalogManager' => __DIR__ . '/src/SpeckCatalogManager',
                ),
            ),
        );
    }

    public function init()
    {
        \Zend\View\Helper\PaginationControl::setDefaultViewPartial('catalogmanager/partial/paginator.phtml');
        $events = StaticEventManager::getInstance();
        $events->attach('EdpUser\Form\Login', 'init', function($e) {
            $form = $e->getTarget();
            $form->addElement('hidden', 'redirect', array(
                'value'   => '/catalogmanager',
            ));
        });
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
