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
        $product = $this->getProduct();
        if($product){
            $this->setProductId($product->getProductId());
        }
        $this->setProduct(null);

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
}
