<?php

namespace Management\Entity;

class ProductUom extends \Catalog\Entity\ProductUom 
{
    protected $productId;
    protected $availabilityIds;
 
    /**
     * Get productId.
     *
     * @return productId
     */
    public function getProductId()
    {
        return $this->productId;
    }
 
    /**
     * Set productId.
     *
     * @param $productId the value to be set
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
 
    /**
     * Get availabilityIds.
     *
     * @return availabilityIds
     */
    public function getAvailabilityIds()
    {
        return $this->availabilityIds;
    }
 
    /**
     * Set availabilityIds.
     *
     * @param $availabilityIds the value to be set
     */
    public function setAvailabilityIds($availabilityIds)
    {
        $this->availabilityIds = $availabilityIds;
        return $this;
    }
}
