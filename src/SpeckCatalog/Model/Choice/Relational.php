<?php

namespace SpeckCatalog\Model\Choice;

use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Model\Choice as Base;

class Relational extends Base
{
    protected $parent;
    protected $product;
    protected $options;
    protected $parentOptions;
    protected $addPrice;

    public function getKey()
    {
        return $this->choiceId;
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

    public function getItemNumber()
    {
        if ($this->getProduct()) {
            return $this->getProduct()->getItemNumber();
        }
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

    /**
     * @return options
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function addOption($option)
    {
        $option->setParent($this);
        $this->options[] = $option;
        return $this;
    }

    /**
     * @param $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = array();

        foreach ($options as $option) {
            $this->options[] = $option;
        }

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

    /**
     * @return parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param $parent
     * @return self
     */
    public function setParent(AbstractModel $parent)
    {
        $this->parent = $parent;
        $this->setOptionId($parent->getOptionId());
        return $this;
    }

    public function __toString()
    {
        if($this->getOverrideName()){
            return $this->getOverrideName();
        } elseif ($this->getProduct()) {
            return $this->getProduct()->getName();
        } else {
            return 'Unnamed Option';
        }
    }

}
