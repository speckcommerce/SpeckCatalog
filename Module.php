<?php

namespace SpeckCatalog;

class Module
{
    protected $view;
    protected $viewListener;
    protected $serviceManager;

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Catalog' => __DIR__ . '/src/Catalog',
                ),
            ),
        );
    }

    public function getConfig()
    {
        $config = array();
        $configFiles = array(
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/module.config.routes.php',
            __DIR__ . '/config/module.config.servicemanager.php',
        );
        foreach($configFiles as $configFile) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
        }
        return $config;
    }

    public function getViewHelperConfig()
    {
        return include(__DIR__ . '/config/services/viewhelpers.php');
    }

    public function getServiceConfig()
    {
        return include(__DIR__ . '/config/services/servicemanager.php');
    }

    public function getControllerConfig()
    {
        return array(
            'initializers' => array(
                function($instance, $sm){
                    if($instance instanceof \Catalog\Service\FormServiceAwareInterface){
                        $sm = $sm->getServiceLocator();
                        $formService = $sm->get('catalog_form_service');
                        $instance->setFormService($formService);
                    }
                },
            ),
        );
    }

    public function onBootstrap($e)
    {
        if($e->getRequest() instanceof \Zend\Console\Request){
            return;
        }

        $app = $e->getParam('application');
        $em  = $app->getEventManager()->getSharedManager();

        $em->attach('ImageUploader\Service\Uploader', 'fileupload.pre', array('Catalog\Event\FileUpload', 'preFileUpload'));
        $em->attach('ImageUploader\Service\Uploader', 'fileupload.post', array('Catalog\Event\FileUpload', 'postFileUpload'));

        $app          = $e->getParam('application');
        $locator      = $app->getServiceManager();
        $this->setServiceManager($locator);
        $renderer     = $locator->get('Zend\View\Renderer\PhpRenderer');
        $renderer->plugin('url')->setRouter($locator->get('Router'));
        $renderer->plugin('headScript')->appendFile('/assets/speck-catalog/js/speck-catalog-manager.js');
        $renderer->plugin('headLink')->appendStylesheet('/assets/speck-catalog/css/speck-catalog.css');
    }

    /**
     * @return serviceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param $serviceManager
     * @return self
     */
    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}
