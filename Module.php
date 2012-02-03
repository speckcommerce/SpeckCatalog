<?php

namespace SpeckCatalog;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager, 
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{
    protected $view;
    protected $viewListener;

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

    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'initializeView'), 50); 

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
    
    public function initializeView($e)
    {
        $events = StaticEventManager::getInstance();
        $app = $e->getParam('application');
        $locator = $app->getLocator();
        $listener = $locator->get('SpeckCatalog\Model\Helper\OptionHelperListener');
        $events->attach('SpeckCatalog\Model\Option', 'getChoices', array($listener, 'getChoices'));
        $config = $e->getParam('config');
        $view = $this->getView($app);
        $viewListener = $this->getViewListener($view, $config);
        $app->events()->attachAggregate($viewListener);
        $events = StaticEventManager::getInstance();
        $viewListener->registerStaticListeners($events, $locator);
    }

    protected function getViewListener($view, $config)
    {
        if ($this->viewListener instanceof \Application\View\Listener) {
            return $this->viewListener;
        }

        $viewListener = new \Application\View\Listener($view, $config->layout);
        $viewListener->setDisplayExceptionsFlag($config->display_exceptions);

        $this->viewListener = $viewListener;
        return $viewListener;
    }

    protected function getView($app)
    {
        if ($this->view) {
            return $this->view;
        }

        $locator = $app->getLocator();
        $view = $locator->get('view');

        $basePath = $app->getRequest()->getBaseUrl();
        $view->plugin('headScript')->appendFile($basePath . '/js/catalogmanager.js');
        $this->view = $view;
        return $view;
    }   
}



