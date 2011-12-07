<?php

namespace Management\Entity;

class Uom extends \Catalog\Entity\Uom
{
    protected $parentProductUomIds = array();
 
    public function getParentProductUomIds()
    {
        return $this->parentProductUomIds;
    }
 
    public function setParentProductUomIds($parentProductUomIds)
    {
        $this->parentProductUomIds = $parentProductUomIds;
        return $this;
    }
}
