<?php

namespace SpeckCatalog\Model;

class ProductUom extends ModelAbstract
{
 

    protected $productUomId;

    protected $uom;
    protected $uomCode = 'ea';

    protected $parentProduct;
    protected $parentProductId;
    
    protected $quantity = 1;

    protected $price = 0;

    protected $retail = 0;

    protected $availabilities;

    public function addAvailability(Availability $availability)
    {
        $this->availabilities[] = $availability;
        return $this;
    }

    public function setAvailabilities($availabilities)
    {
        $this->availabilities = array();
        foreach($availabilities as $availability){
            $this->addAvailability($availability);
        }
        return $this;
    }
 
    public function setPrice($price)
    {
        $this->price = (float) $price;
        return $this;
    }

    public function setRetail($retail)
    {

        $this->retail = (float) $retail;
        return $this;
    }
 
    public function getRetail()
    {
        return $this->retail;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getAvailabilities()
    {
        return $this->availabilities;
    }

    public function hasAvailabilities()
    {
        if($this->getAvailabilities() && count($this->getAvailabilities()) > 0){
            return true;
        }
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
 
    public function getUom()
    {
        return $this->uom;
    }
 
    public function setUom(Uom $uom)
    {
        $this->uom = $uom;
        return $this;
    }
 
    public function getParentProduct()
    {
        return $this->parentProduct;
    }
 
    public function setParentProduct(Product $parentProduct=null)
    {
        $this->parentProduct = $parentProduct;
        return $this;
    }

    public function getProductUomId()
    {
        return $this->productUomId;
    }
 
    public function setProductUomId($productUomId)
    {
        $this->productUomId = $productUomId;
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

    public function setUomCode($uomCode)
    {
        $this->uomCode = $uomCode;
        return $this;
    }
 
    public function getUomCode()
    {
        return $this->uomCode;
    } 

    public function __toString()
    {
        return strtoupper($this->getUomCode()) . ' ' . $this->getQuantity() . ' - $' . number_format($this->getPrice(), 2);
    }
}
