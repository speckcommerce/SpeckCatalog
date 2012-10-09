<?php

namespace Catalog\Model\Choice;

use Catalog\Model\Choice as Base;

class Relational extends Base
{
    protected $product;
    protected $options;
    protected $parentOptions;
    protected $addPrice;

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
}
