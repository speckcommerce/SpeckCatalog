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

    public function getPrice()
    {
        if ($this->has('product')) {
            return $this->getProduct()->getPrice();
        }
        return 0;
    }

    public function getRecursivePrice($parentProductPrice = 0, $retailPrice = false)
    {
        if ($this->has('product')) {
            $productPrice = $this->getProduct()->getRecursivePrice($retailPrice);
            return $productPrice + $this->getAdjustmentPrice($productPrice);
        } else {
            $adjustedPrice = $this->getAdjustedPrice($retailPrice);
            $adjustmentPrice = $adjustedPrice - $parentProductPrice;

            $price = 0;
            if ($this->has('options')) {
                foreach ($this->getOptions() as $option) {
                    $price += $option->getRecursivePrice($adjustedPrice, $retailPrice);
                }
            }

            return ($adjustmentPrice + $price) >= -$parentProductPrice
                ? $adjustmentPrice + $price
                : -$parentProductPrice;
        }
    }

    public function getAdjustedPrice($retailPrice = false)
    {
        $parentProductPrice = $this->getParentProductPrice($retailPrice);
        return $parentProductPrice + $this->getAdjustmentPrice($parentProductPrice);
    }

    public function getParentProductPrice($retailPrice = false)
    {
        if ($this->has('parent')) {
            return $this->getParent()->getAdjustedPrice($retailPrice);
        }
        return 0;
    }


    public function getAdjustmentPrice($parentPrice)
    {
        if ($this->getPriceDiscountFixed()) {
            return -$this->getPriceDiscountFixed();
        } elseif ($this->getPriceDiscountPercent()) {
            return $parentPrice * -($this->getPriceDiscountPercent()/100);
        } elseif ($this->getPriceNoCharge()) {
            return -$parentPrice;
        } elseif ($this->getPriceOverrideFixed()) {
            return $this->getPriceOverrideFixed() - $parentPrice;
        } else {
            return 0;
        }
    }


    public function getItemNumber()
    {
        if ($this->getProduct()) {
            return $this->getProduct()->getItemNumber();
        }
    }


    public function getProductTypeId()
    {
        if ($this->getProduct()) {
            return $this->getProduct()->getProductTypeId();
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
        $this->options = [];

        foreach ($options as $option) {
            $this->addOption($option);
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

    public function getAddPrice($retailPrice = false)
    {
        if ($this->addPrice) {
            return $this->addPrice;
        } elseif ($this->has('product')) {
            $productPrice = $this->getProduct()->getPrice($retailPrice);
            return $productPrice + $this->getAdjustmentPrice($productPrice);
        } else {
            return $this->getAdjustedPrice($retailPrice) - $this->getParentProductPrice($retailPrice);
        }
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
        if ($this->getOverrideName()) {
            $str = $this->getOverrideName();
        } elseif ($this->has('product')) {
            $str = $this->getProduct()->getName();
        } else {
            $str = 'Unnamed Choice';
        }
        return $str;
    }
}
