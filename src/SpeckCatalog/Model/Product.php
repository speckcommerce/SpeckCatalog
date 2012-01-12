<?php

namespace SpeckCatalog\Model;

class Product extends RevisionAbstract
{
    //shell view        
    protected $productId;
    protected $name;
    protected $description;
    protected $type; 
    //protected $features;
    //protected $attributes;
    protected $options;
    protected $parentChoices;
    
    //item view
    protected $manufacturer;
    protected $manufacturerCompanyId;
    protected $itemNumber;
    protected $uoms;

    public function __construct($type=null)
    {
        if(!$type){
            $type = 'shell';
        }
        $this->setType($type);
    }

    public function setType($type, Item $item=null)
    {
        if($type === null) {
            throw new \RuntimeException("no type specified! '{$this->type}'");  
        }
        if($type !== 'shell' && $type !== 'item' && $type !== 'builder'){
            throw new \InvalidArgumentException("invalid type, must be 'shell', 'product', or 'builder'");
        }
        $this->type = $type;
        return $this;
    }

    public function addOption(Option $option)
    {
        $this->options[] = $option;
        return $this;
    }

    public function setOptions($options)
    {
        if(is_array($options) && count($options) > 0){
            $this->options = array();
            foreach($options as $option){
                $this->addOption($option);
            }
        }
        return $this;
    }
 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
 
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    public function setPrice($price)
    {
        if(!is_float($price)){ 
            throw new \InvalidArgumentException("price must be float - '{$price}'");
        }
        $this->price = $price;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }
 
    public function getName()
    {
        return $this->name;
    }
 
    public function getDescription()
    {
        return $this->description;
    }
 
    public function getProductId()
    {
        return $this->productId;
    }
 
    public function getType()
    {
        return $this->type;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getParentChoices()
    {
        return $this->parentChoices;
    }
 
    public function setParentChoices($parentChoices)
    {
        $this->parentChoices = $parentChoices;
        return $this;
    }

    public function forcedItem(){
        if($this->getType() === 'item'){
            return true;
        }else{
            die('not type "item"');
        }
    }
    public function isItem(){
        if($this->getType() === 'item'){
            return true;
        }
    }
    public function hasUoms(){
        if(is_array($this->getUoms()) && count($this->getUoms()) > 0){
            return true;
        }
    }
    
    public function getManufacturer()
    {
        $this->forcedItem();
        return $this->manufacturer;
    }
 
    public function setManufacturer($manufacturer)
    {
        $this->forcedItem();
        $this->manufacturer = $manufacturer;
        return $this;
    }
 
    public function getManufacturerCompanyId()
    {
        $this->forcedItem();
        return $this->manufacturerCompanyId;
    }
 
    public function setManufacturerCompanyId($companyId)
    {
        $this->forcedItem();
        $this->manufacturerCompanyId = $companyId;
        return $this;
    }
 
    public function getItemNumber()
    {
        $this->forcedItem();
        return $this->itemNumber;
    }
 
    public function setItemNumber($itemNumber)
    {
        $this->forcedItem();
        $this->itemNumber = $itemNumber;
        return $this;
    }
 
    public function getUoms()
    {
        $this->forcedItem();
        return $this->uoms;
    }
 
    public function setUoms($uoms)
    {
        $this->forcedItem();
        $this->uoms = $uoms;
        return $this;
    }
}
