<?php

namespace SpeckCatalogManager\Entity;

class ProductUom extends \Catalog\Entity\ProductUom 
{
    protected $parentProductId;
    protected $availabilityIds;
    protected $uomCode;
 
    public function getAvailabilityIds()
    {
        return $this->availabilityIds;
    }
 
    public function setAvailabilityIds($availabilityIds)
    {
        $this->availabilityIds = $availabilityIds;
        return $this;
    }
 
    public function getUomCode()
    {
        return $this->uomCode;
    }
 
    public function setUomCode($uomCode)
    {
        $this->uomCode = $uomCode;
        return $this;
    }
 
    public function getParentProductId()
    {
        return $this->parentProductId;
    }
 
    public function setParentProductId($parentProductId)
    {
        $this->parentProductId = $parentProductId;
        return $this;
    }
}
