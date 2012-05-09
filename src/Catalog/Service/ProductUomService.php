<?php

namespace Catalog\Service;

class ProductUomService extends ServiceAbstract
{
    protected $availabilityService;
    protected $uomService;

    public function _populateModel($productUom)
    {
        $productUom->setAvailabilities(
            $this->getAvailabilityService()->getAvailabilitiesByParentProductUomId($productUom->getRecordId())
        );
        $productUom->setUoms($this->getUomService()->getAll());
        $productUom->setUom($this->getUomService()->getById($productUom->getUomCode()));

        return $productUom;
    }

    public function getModel($constructor=null)
    {
        $model = $this->getModelMapper()->getModel($constructor);
        $model->setUom($this->uomService->getById($model->getUomCode()));
        $model->setUoms($this->getUomService()->getAll());
        
        return $model;
    }

    public function getProductUomsByParentProductId($id)
    {
        $productUoms = $this->modelMapper->getProductUomsByParentProductId($id);
        $return = array();
        foreach ($productUoms as $productUom){
            $return[] = $this->populateModel($productUom);
        }
        return $return;
    }
      
    public function getAvailabilityService()
    {
        return $this->availabilityService;
    }
 
    public function setAvailabilityService($availabilityService)
    {
        $this->availabilityService = $availabilityService;
        return $this;
    }

    public function getUomService()
    {
        return $this->uomService;
    }
 
    public function setUomService($uomService)
    {
        $this->uomService = $uomService;
        return $this;
    }
}
