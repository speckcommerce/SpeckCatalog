<?php

namespace SpeckCatalogManager\Entity;
use \SpeckCatalog\Entity\Product as CatalogProduct;
class Product extends CatalogProduct
{
    
    protected $itemId;
    protected $optionIds = array();
    protected $parentChoiceIds = array();

    public function __construct($str, Item $item=null)
    {
        parent::__construct($str);
        if(!$item && $str === 'product'){
            $this->setItem(new Item);
        }
    }

    public function getItemId()
    {
        return $this->itemId;
    }
 
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }
 
    public function getOptionIds()
    {
        return $this->optionIds;
    }
 
    public function setOptionIds($optionIds)
    {
        $this->optionIds = $optionIds;
        return $this;
    }
 
    public function getParentChoiceIds()
    {
        return $this->parentChoiceIds;
    }
 
    public function setParentChoiceIds($parentChoiceIds)
    {
        $this->parentChoiceIds = $parentChoiceIds;
        return $this;
    }

    public function deflate()
    {
        $item = $this->getItem();
        if($item){
            $this->setItemId($item->getItemId());
        }
        $this->setItem(null);

        $parentChoiceIds = array();
        if(count($this->getParentChoices()) > 0){
            foreach($this->getParentChoices() as $choice){
                $parentChoiceIds[] = $choice->getChoiceId();
            }
        }
        $this->setParentChoiceIds($parentChoiceIds);
        $this->setParentChoices(null);
        
        $optionIds = array();
        if(count($this->getOptions()) > 0){
            foreach($this->getOptions() as $option){
                $OptionIds[] = $option->getOptionId();
            }
        }
        $this->setOptionIds($optionIds);
        $this->setOptions(null);
        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }
}
