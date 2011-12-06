<?php

namespace Management\Entity;

class Availability extends \Catalog\Entity\Availability
{
    protected $productUomId;

    public function getProductUomId()
    {
        return $this->productUomId;
    }
 
    public function setProductUomId($productUomId)
    {
        $this->productUomId = $productUomId;
        return $this;
    }
}
