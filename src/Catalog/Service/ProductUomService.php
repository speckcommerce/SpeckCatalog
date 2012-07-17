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
        $productUom->setUom($this->getUomService()->getById($productUom->getUomCode()));

        return $productUom;
    }

    public function getModel($constructor=null)
    {
        $model = $this->getModelMapper()->getModel($constructor);
        $model->setUom($this->getUomService()->getById($model->getUomCode()));

        return $model;
    }

    public function getProductUomsByParentProductId($id)
    {
        $productUoms = $this->getModelMapper()->getProductUomsByParentProductId($id);
        $return = array();
        foreach ($productUoms as $productUom){
            $return[] = $this->populateModel($productUom);
        }
        return $return;
    }

    public function getAvailabilityService()
    {
        if(null === $this->availabilityService){
            $this->availabilityService = $this->getServiceManager()->get('catalog_availability_service');
        }
        return $this->availabilityService;
    }

    public function getUomService()
    {
        if(null === $this->uomService){
            $this->uomService = $this->getServiceManager()->get('catalog_uom_service');
        }
        return $this->uomService;
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_product_uom_mapper');
        }
        return $this->modelMapper;
    }

}
