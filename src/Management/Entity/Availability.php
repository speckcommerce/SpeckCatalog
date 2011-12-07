<?php

namespace Management\Entity;

class Availability extends \Catalog\Entity\Availability
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
