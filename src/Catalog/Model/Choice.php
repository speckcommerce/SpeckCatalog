<?php

namespace Catalog\Model;

use Exception;

class Choice extends LinkedModelAbstract
{
    //field holds name for 'choice', override name for 'product'
    /**
     * overrideName 
     * 
     * @var string
     * @access protected
     */
    protected $overrideName;
 
    /**
     * product 
     * 
     * @var object Catalog\Model\Product
     * @access protected
     */
    protected $product;
    
    /**
     * productId 
     * 
     * @var int
     * @access protected
     */
    protected $productId;

    /**
     * type 
     * 
     * @var string
     * @access protected
     */
    protected $type = 'choice';  // choice or product

    //only when type is product
    //protected $priceDiscountFixed;
    
    //only when type is product
    //protected $priceNoCharge = false;
    
    //only when type is product
    //protected $priceDiscountPercent;

    //only when type is product
    //protected $priceOverrideFixed;
    
    protected $targetUomDiscount;

    protected $allUomsDiscount;
   
    /**
     * options 
     * 
     * @var array
     * @access protected
     */
    protected $options;

    /**
     * parentOptions 
     * 
     * @var array
     * @access protected
     */
    protected $parentOptions;

    /**
     * naChoices 
     * 
     * @var array
     * @access protected
     */
    protected $naChoices;


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
 
    public function __toString()
    {
        if($this->getOverrideName()){
            return (string) $this->getOverrideName();
        }elseif($this->getProduct()){
            return (string) $this->getProduct()->getName();
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

    public function hasProductUoms()
    {
        if($this->hasProduct() && $this->getProduct()->hasUoms()){
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
 
    public function getPriceDiscountFixed()
    {
        return $this->priceDiscountFixed;
    }
 
    public function setPriceDiscountFixed($priceDiscountFixed)
    {
        $this->priceDiscountFixed = $priceDiscountFixed;
        return $this;
    }
 
    public function getPriceNoCharge()
    {
        return $this->priceNoCharge;
    }
 
    public function setPriceNoCharge($priceNoCharge)
    {
        $this->priceNoCharge = $priceNoCharge;
        return $this;
    }
 
    public function getPriceDiscountPercent()
    {
        return $this->priceDiscountPercent;
    }
 
    public function setPriceDiscountPercent($priceDiscountPercent)
    {
        $this->priceDiscountPercent = $priceDiscountPercent;
        return $this;
    }
 
    public function getPriceOverrideFixed()
    {
        return $this->priceOverrideFixed;
    }
 
    public function setPriceOverrideFixed($priceOverrideFixed)
    {
        $this->priceOverrideFixed = $priceOverrideFixed;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
 
    public function setType($type)
    {
        if($type === 'choice' || $type === 'product'){
            $this->type = $type;
        }else{
            throw new Exception('invalid type - ' . $type);
        }
        return $this;
    }

    public function isShared()
    {
        //todo: get parent options and count
        return false;    
    }

    public function getParentOptions()
    {
        return $this->parentOptions;
    }

    public function setParentOptions($parentOptions)
    {
        $this->parentOptions = $parentOptions;
        return $this;
    }
}
