<?php

namespace SpeckCatalogManager\Entity;

class Product extends \SpeckCatalog\Entity\Product
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
        $shell = $this->getParentShell();
        if($shell){
            $this->setParentShellId($shell->getShellId());
        }
        $this->setParentShell(null);
        
        $company = $this->getManufacturer();
        if($company){
            $this->setCompanyId($company->getCompanyId());
        }
        $this->setManufacturer(null);

        $uomIds = array();
        if(count($this->getUoms()) > 0){
            foreach($this->getUoms() as $productUom){
                $uomIds[] = $productUom->getProductUomId();
            }
        }
        $this->setUomIds($uomIds);
        $this->setUoms(null);
        return $this;
    }
}
