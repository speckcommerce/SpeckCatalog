<?php

namespace Catalog\Model;

class Product extends ModelAbstract
{
    //shell view        
    protected $type; 
    protected $productId;
    protected $name;
    protected $description;
    //protected $features;
    //protected $attributes;
    protected $options;
    protected $parentChoices;
    
    //item view
    protected $manufacturer;
    protected $manufacturerCompanyId;
    protected $companies;

    protected $itemNumber;
    protected $uoms;

    protected $specs;

    public function setType($type = null)
    {
        if($type === null) {
            throw new \RuntimeException("no type specified!");  
        }

        if($type !== 'shell' && $type !== 'item' && $type !== 'builder'){
            throw new \InvalidArgumentException("invalid type, must be 'shell', 'item', or 'builder'");
        }
        
        $this->type = $type;
        return $this;
    }

    public function __construct($type=null)
    {
        if(!$type){
            $type = 'shell';
        }
        $this->setType($type);
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
        $this->productId = (int) $productId;
        return $this;
    }

    public function setPrice($price)
    {
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

    public function isItem(){
        if($this->getType() === 'item'){
            return true;
        }
    }

    public function hasUoms()
    {
        if(is_array($this->getUoms()) && count($this->getUoms()) > 0){
            return true;
        }
    }
    public function hasOptions()
    {
        if($this->getOptions() && count($this->getOptions()) > 0){
            return true;
        }
    }
    
    public function getManufacturer()
    {
        return $this->manufacturer;
    }
 
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }
 
    public function getManufacturerCompanyId()
    {
        return $this->manufacturerCompanyId;
    }
 
    public function setManufacturerCompanyId($companyId)
    {
        $this->manufacturerCompanyId = (int) $companyId;
        return $this;
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
 
    public function getUoms()
    {
        return $this->uoms;
    }
 
    public function setUoms($uoms)
    {
        $this->uoms = $uoms;
        return $this;
    }
    public function __toString()
    {
        if($this->getName()){
            return $this->getName();
        }else{
            return '';
        }
    }
 
    public function getCompanies()
    {
        return $this->companies;
    }

    public function setCompanies($companies)
    {
        $this->companies = $companies;
        return $this;
    }
    public function getId()
    {
        return $this->productId;
    }      

    public function getSpecs()
    {
        return $this->specs;
    }

    public function setSpecs($specs)
    {
        $this->specs = $specs;
        return $this;
    }

    public function hasSpecs()
    {
        if ($this->getSpecs()){
            return true;
        }
    }
}
