<?php

namespace Catalog\Service;

class AvailabilityService extends ServiceAbstract
{
    protected $companyService;

    public function populateModel($availability)
    {
        $availability->setCompanies($this->getCompanyService()->getAll());
        $availability->setDistributor($this->getCompanyService()->getById($availability->getDistributorCompanyId()));
        return $availability;
    }

    public function newProductUomAvailability($parentId)
    {
        $availability = $this->getModelMapper()->newModel();
        $availability->setParentProductUomId($parentId);
        $this->update($availability);
        $availability->setCompanies($this->getCompanyService()->getAll());
        return $availability;
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
}
