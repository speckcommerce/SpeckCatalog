<?php

namespace SpeckCatalog\Service;

class ProductUomService extends ServiceAbstract
{
    protected $availabilityService;

    public function populateModel($productUom)
    {
        $productUom->setAvailabilities(
            $this->getAvailabilityService()->getAvailabilitiesByParentProductUomId($productUom->getProductUomId())
        );
        return $productUom;
    }

    public function newProductProductUom($parentId)
    {
        $productUom = $this->getModelMapper()->newModel();
        $productUom->setParentProductId($parentId);
        $this->modelMapper->update($productUom);
        return $productUom;    
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
      
 
    /**
     * Get availabilityService.
     *
     * @return availabilityService
     */
    public function getAvailabilityService()
    {
        return $this->availabilityService;
    }
 
    /**
     * Set availabilityService.
     *
     * @param $availabilityService the value to be set
     */
    public function setAvailabilityService($availabilityService)
    {
        $this->availabilityService = $availabilityService;
        return $this;
    }
}
