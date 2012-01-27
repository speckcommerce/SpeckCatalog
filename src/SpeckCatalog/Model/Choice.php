<?php

namespace SpeckCatalog\Model;

class Choice extends ModelAbstract
{
    protected $choiceId;

    protected $overrideName;
 
    protected $product;

    protected $targetUom;

    protected $targetUomDiscount;

    protected $allUomsDiscount;
   
    protected $parentOption;
    protected $parentOptionId;

    protected $options;

    protected $naChoices = array();
 
    public function getProduct()
    {
        return $this->product;
    }
 
    public function setProduct(Product $product)
    {
        $this->targetUom = null; //keep this, if the product changes, the targetuom must be reset. 
        $this->product = $product;
        return $this;
    }

    public function getTargetUom()
    {
        return $this->targetUom;
    }
    
    public function setTargetUom(ProductUom $targetUom)
    {
        $shell = $this->getShell();
        if($shell->getType() !== 'product'){
            throw new \RuntimeException('shell is not product, can not have target uom!');
        }
        $productUomIds=array();
        foreach($shell->getProduct()->getUoms() as $productUom){
            $productUomIds[] = $productUom->getProductUomId();
        }
        if(!in_array($targetUom->getProductUomId(), $productUomIds)){
            throw new \RuntimeException('shells product does not contain that productUom!');
        }
        $this->targetUom = $targetUom;
        return $this;
    }
 
    public function getTargetUomDiscount()
    {
        return $this->targetUomDiscount;
    }
 
    public function setTargetUomDiscount($targetUomDiscount)
    {
        $this->targetUomDiscount = $targetUomDiscount;
        return $this;
    }
 
    public function getAllUomsDiscount()
    {
        return $this->allUomsDiscount;
    }
 
    public function setAllUomsDiscount($allUomsDiscount)
    {
        $this->allUomsDiscount = $allUomsDiscount;
        return $this;
    }
 
    public function getChoiceId()
    {
        return (int) $this->choiceId;
    }
 
    public function setChoiceId($choiceId)
    {
        $this->choiceId = (int) $choiceId;
        return $this;
    }

    public function hasOptions()
    {
        if(!$this->getProduct() && $this->getOptions()){
            return true;
        }
    }

    public function getNaChoices()
    {
        return $this->naChoices;
    }
 
    public function setNaChoices(Choice $naChoices)
    {
        $this->naChoices = $naChoices;
        return $this;
    }
 
    public function getOverrideName()
    {
        return $this->overrideName;
    }
 
    public function setOverrideName($overrideName)
    {
        $this->overrideName = $overrideName;
        return $this;
    }
 

    public function getParentOption()
    {
        return $this->parentOption;
    }
 
    public function setParentOption($parentOption)
    {
        $this->parentOption = $parentOption;
        return $this;
    }
 

    public function getParentOptionId()
    {
        return $this->parentOptionId;
    }
 
    public function setParentOptionId($parentOptionId)
    {
        $this->parentOptionId = $parentOptionId;
        return $this;
    }
    public function __toString()
    {
        if($this->getOverrideName()){
            return $this->getOverrideName();
        }elseif($this->getProduct()){
            return $this->getProduct()->getName();
        }else{
            return '';
        }
    }
 
    public function getProductId()
    {
        return $this->productId;
    }
 
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    public function hasProduct()
    {
        if($this->getProduct()){
            return true;
        }
    }
 

    public function getOptions()
    {
        return $this->options;
    }
 
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
