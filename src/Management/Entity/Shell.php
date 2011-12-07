<?php

namespace Management\Entity;

class Shell extends \Catalog\Entity\Shell
{
    protected $productId;
    protected $optionIds = array();
    protected $parentChoiceIds = array();
 
    public function getProductId()
    {
        return $this->productId;
    }
 
    public function setProductId($productId)
    {
        $this->productId = $productId;
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
        $product = static::getProduct();
        if($product){
            $this->setProductId($product->getProductId());
        }
        static::setProduct(null);

        $parentChoiceIds = array();
        if(count(static::getParentChoices()) > 0){
            foreach(static::getParentChoices() as $choice){
                $parentChoiceIds[] = $choice->getChoiceId();
            }
        }
        $this->setParentChoiceIds($parentChoiceIds);
        static::setParentChoices(null);
        
        $optionIds = array();
        if(count(static::getOptions()) > 0){
            foreach(static::getOptions() as $option){
                $OptionIds[] = $option->getOptionId();
            }
        }
        $this->setOptionIds($optionIds);
        static::setOptions(null);
        return $this;
    }
}
