<?php

namespace SpeckCatalog\Service;

class AvailabilityService extends ServiceAbstract
{
    protected $companyService;

    public function populateModel($availability)
    {
        $availability->setCompanies($this->getCompanyService()->getAll());
        return $availability;
    }

    public function newProductUomAvailability($parentId)
    {
        $availability = $this->getModelMapper()->newModel();
        $availability->setParentProductUomId($parentId);
        $this->modelMapper->update($availability);
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
}
