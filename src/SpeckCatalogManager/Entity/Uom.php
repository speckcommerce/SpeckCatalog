<?php

namespace SpeckCatalogManager\Entity;

class Uom extends \SpeckCatalog\Entity\Uom
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
    public function __toString()
    {
        return $this->getName();
    }
}
