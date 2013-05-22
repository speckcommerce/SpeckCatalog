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

        $em->attach('ImageUploader\Service\Uploader', 'fileupload.pre',  array('SpeckCatalog\Event\FileUpload', 'preFileUpload'));
        $em->attach('ImageUploader\Service\Uploader', 'fileupload.post', array('SpeckCatalog\Event\FileUpload', 'postFileUpload'));

        $em->attach('SpeckCatalog\Service\ProductUom', 'update.post', array('SpeckCatalog\Event\ProductUomPersist', 'postPersist'));
        $em->attach('SpeckCatalog\Service\ProductUom', 'insert.post', array('SpeckCatalog\Event\ProductUomPersist', 'postPersist'));

        //install event listeners
        $em->attach('SpeckInstall\Controller\InstallController', 'install.create_tables.post', array($this, 'constraints'),1);
    }

    public function constraints($e)
    {
        try {
            $mapper = $e->getParam('mapper');

            //check dependencies
            $tables = $mapper->query("show tables like 'contact_company'");
            if(!count($tables)) {
                return array(false, 'SpeckCatalog could not add table constraints - missing table contact_company from SpeckContact');
            }
            $tables = $mapper->query("show tables like 'catalog_product'");
            if(!count($tables)) {
                return array(false, 'SpeckCatalog could not add table constraints - missing tables provided by SpeckCatalog');
            }

            $alter = file_get_contents(__DIR__ .'/data/alter.sql');
            $mapper->query($alter);

        } catch (\Exception $e) {
            return array(false, "SpeckCatalog could not add table constraints - " . $e->getMessage());
        }

        return array(true, "SpeckCatalog added table constraints");
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
