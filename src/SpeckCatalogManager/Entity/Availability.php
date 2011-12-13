<?php

namespace SpeckCatalogManager\Entity;

class Availability extends \SpeckCatalog\Entity\Availability
{
    protected $parentProductUomId;
    protected $companyId;
 
    public function getParentProductUomId()
    {
        return $this->parentProductUomId;
    }
 
    public function setParentProductUomId($parentProductUomId)
    {
        $this->parentProductUomId = $parentProductUomId;
        return $this;
    }
 
    public function getCompanyId()
    {
        return $this->companyId;
    }
 
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
        return $this;
    }
}
