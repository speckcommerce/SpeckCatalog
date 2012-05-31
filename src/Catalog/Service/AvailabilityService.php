<?php

namespace Catalog\Service;

class AvailabilityService extends ServiceAbstract
{
    protected $companyService;

    public function _populateModel($availability)
    {
        $availability->setCompanies($this->getCompanyService()->getAll());
        $availability->setDistributor(
            $this->getCompanyService()->getById($availability->getDistributorCompanyId())
        );
        return $availability;
    }

    public function getModel($constructor=null)
    {
        $model = $this->getModelMapper()->getModel($constructor);
        $model->setCompanies($this->getCompanyService()->getAll());
        return $model;
    }       

    public function getAvailabilitiesByParentProductUomId($id)
    {
        $availabilities = $this->getModelMapper()->getByParentProductUomId($id);
        $return = array();
        foreach ($availabilities as $availability){
            $return[] = $this->populateModel($availability);
        }
        return $return;
    }  

    public function getCompanyService()
    {
        return $this->companyService;
    }
 
    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }
 
    public function getProductUomService()
    {
        return $this->productUomService;
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_availability_mapper');
        }
        return $this->modelMapper;         
    }    
}
