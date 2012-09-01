<?php

namespace Catalog\Entity;

class Choice extends AbstractEntity
{
    protected $overrideName;
    protected $choiceId;
    protected $productId;
    protected $optionId;
    protected $sortWeight = 0;

    //non db fields
    protected $product;
    protected $options;
    protected $parentOptions;
    protected $addPrice;

    /**
     * @return overrideName
     */
    public function getOverrideName()
    {
        return $this->overrideName;
    }

    /**
     * @param $overrideName
     * @return self
     */
    public function setOverrideName($overrideName)
    {
        $this->overrideName = $overrideName;
        return $this;
    }

    /**
     * @return choiceId
     */
    public function getChoiceId()
    {
        return $this->choiceId;
    }

    /**
     * @param $choiceId
     * @return self
     */
    public function setChoiceId($choiceId)
    {
        $this->choiceId = $choiceId;
        return $this;
    }

    /**
     * @return productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param $productId
     * @return self
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return optionId
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @param $optionId
     * @return self
     */
    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;
        return $this;
    }

    /**
     * @return sortWeight
     */
    public function getSortWeight()
    {
        return $this->sortWeight;
    }

    /**
     * @param $sortWeight
     * @return self
     */
    public function setSortWeight($sortWeight)
    {
        $this->sortWeight = $sortWeight;
        return $this;
    }

    /**
     * @return options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return parentOptions
     */
    public function getParentOptions()
    {
        return $this->parentOptions;
    }

    /**
     * @param $parentOptions
     * @return self
     */
    public function setParentOptions($parentOptions)
    {
        $this->parentOptions = $parentOptions;
        return $this;
    }

    /**
     * @return product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param $product
     * @return self
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    public function getPrice(){
        if ($this->has('product')) {
            return $this->getProduct()->getPrice();
        }
    }

    public function getRecursivePrice()
    {
        $price = 0;
        if ($this->has('product')) {
            //note: need to get all the extra logic in here for price modifers/etc
            $price = $price + $this->getProduct()->getPrice();
        }
        return $price;
    }

    /**
     * @return addPrice
     */
    public function getAddPrice()
    {
        return $this->addPrice;
    }

    /**
     * @param $addPrice
     * @return self
     */
    public function setAddPrice($addPrice)
    {
        $this->addPrice = $addPrice;
        return $this;
    }

    public function __toString()
    {
        $string = '';
        if($this->getOverrideName()){
            $string .= $this->getOverrideName();
        }elseif($this->has('product')){
            $string .= $this->getProduct()->getName();
        }
        return $string;
    }
}
