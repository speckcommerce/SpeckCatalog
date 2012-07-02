<?php

namespace CatalogManager\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

class CatalogManagerService implements ServiceManagerAwareInterface
{
    protected $productService;

    protected $serviceManager;

    protected $optionService;

    public function getModel($className, $id)
    {
        return $this->getModelService($className)->getById($id);
    }

    public function getAll($class)
    {
        return $this->getModelService($class)->getAll();
    }

    public function getModelService($class)
    {
        $getModelService = 'get' . ucfirst($class) . 'Service';
        return $this->$getModelService();
    }

    public function update($class, $id, $post)
    {
        echo $this->getModelService($class)->updateModelFromArray($post); die();
    }

    public function getCatalogManagerForm($className, $model)
    {
        return $this->getModelService($className)->getCatalogManagerForm($model);
    }

    public function getProductService()
    {
        if(null === $this->productService){
            $this->productService = $this->getServiceManager()->get('catalogmanager_product_service');
        }
        return $this->productService;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
    }

    public function getOptionService()
    {
        if(null === $this->optionService){
            $this->optionService = $this->getServiceManager()->get('catalogmanager_option_service');
        }
        return $this->optionService;
    }
}
