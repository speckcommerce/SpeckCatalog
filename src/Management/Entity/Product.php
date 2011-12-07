<?php

namespace Management\Entity;

class Product extends \Catalog\Entity\Product
{
    protected $uomIds;
    protected $companyId;
    protected $parentShellId;

    public function getUomIds()
    {
        return $this->uomIds;
    }

    public function setUomIds($uomIds)
    {
        $this->uomIds = $uomIds;
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
 
    public function getParentShellId()
    {
        return $this->parentShellId;
    }
 
    public function setParentShellId($parentShellId)
    {
        $this->parentShellId = $parentShellId;
        return $this;
    }
    
    public function deflate()
    {
        $shell = static::getParentShell();
        if($shell){
            $this->setParentShellId($shell->getShellId());
        }
        static::setParentShell(null);
        
        $company = static::getManufacturer();
        if($company){
            $this->setCompanyId($company->getCompanyId());
        }
        static::setManufacturer(null);

        $uomIds = array();
        if(count(static::getUoms()) > 0){
            foreach(static::getUoms() as $productUom){
                $uomIds[] = $productUom->getProductUomId();
            }
        }
        $this->setUomIds($uomIds);
        static::setUoms(null);
        return $this;
    }
}
