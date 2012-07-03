<?php

namespace CatalogManager\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

class CatalogManagerService implements ServiceManagerAwareInterface
{
    protected $productService;

    protected $serviceManager;

    protected $optionService;

    protected $companyService;

    public function getModel($className, $id)
    {
        return $this->getService($className)->getById($id);
    }

    public function getAll($class)
    {
        return $this->getService($class)->getAll();
    }

    public function getService($class)
    {
        $getService = 'get' . ucfirst($class) . 'Service';
        return $this->$getService();
    }

    public function update($class, $id, $post)
    {
        echo $this->getService($class)->updateModelFromArray($post); die();
    }

    public function getCatalogManagerForm($className, $model)
    {
        return $this->getService($className)->getCatalogManagerForm($model);
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

    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
    }

    public function getCompanyService()
    {
        if(null === $this->companyService){
            $this->companyService = $this->getServiceManager()->get('catalogmanager_company_service');
        }
        return $this->companyService;
    }
}
