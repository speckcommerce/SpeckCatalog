<?php

namespace SpeckCatalog\Model;

class Item extends RevisionAbstract
{
    protected $productId;


    public function getUoms()
    {
        return $this->uoms;
    }

    public function addUom(ItemUom $uom)
    {
        $this->uoms[] = $uom;
        return $this;
    }

    public function setUoms($uoms=null)
    {
        $this->uoms = array();
        if(is_array($uoms)){
            foreach($uoms as $uom){
                $this->addUom($uom);
            }
        }
        return $this;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    public function setManufacturer(Company $manufacturer=null)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }
 
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }
 
    public function getManufacturer()
    {
        return $this->manufacturer;
    }


    public function getHcpcs()
    {
        return $this->hcpcs;
    }
 
    public function getItemNumber()
    {
        return $this->itemNumber;
    }
 
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }
}
