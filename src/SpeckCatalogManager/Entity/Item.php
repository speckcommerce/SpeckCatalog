<?php

namespace SpeckCatalogManager\Entity;

class Item extends \SpeckCatalog\Entity\Item
{
    protected $uomIds;
    protected $companyId;
    protected $parentProductId;

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
 
    public function getParentProductId()
    {
        return $this->parentProductId;
    }
 
    public function setParentProductId($parentProductId)
    {
        $this->parentProductId = $parentProductId;
        return $this;
    }
    
    public function deflate()
    {
        $product = $this->getParentProduct();
        if($product){
            $this->setParentProductId($product->getProductId());
        }
        $this->setParentProduct(null);
        
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
