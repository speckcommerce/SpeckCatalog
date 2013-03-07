<?php

namespace SpeckCatalog;

class Module
{
    protected $serviceManager;

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
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

    public function onBootstrap($e)
    {
        if($e->getRequest() instanceof \Zend\Console\Request){
            return;
        }

        $app = $e->getParam('application');

        $locator  = $app->getServiceManager();
        $this->setServiceManager($locator);

        $em  = $app->getEventManager()->getSharedManager();

        $em->attach('ImageUploader\Service\Uploader', 'fileupload.pre', array('SpeckCatalog\Event\FileUpload', 'preFileUpload'));
        $em->attach('ImageUploader\Service\Uploader', 'fileupload.post', array('SpeckCatalog\Event\FileUpload', 'postFileUpload'));

        //install event listeners
        $em->attach('SpeckInstall\Controller\InstallController', 'install.create_tables', array($this, 'createTables'));
        $em->attach('SpeckInstall\Controller\InstallController', 'install.create_tables.post', array($this, 'constraints'));
    }

    public function createTables($sm)
    {
        $create = file_get_contents(__DIR__ .'/data/schema.sql');
        return "SpeckCatalog created tables";
    }

    public function constraints($sm)
    {
        $alter = file_get_contents(__DIR__ .'/data/alter.sql');
        return "SpeckCatalog added table constraints";
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
