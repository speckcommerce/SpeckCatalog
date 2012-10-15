<?php

namespace Catalog\Model\Option;

use Catalog\Model\Option as Base;

class Relational extends Base
{
    protected $parentProducts;
    protected $choices;
    protected $images;

    public function getRecursivePrice()
    {
        $price = 0;
        if ($this->getRequired()) {
            //add the cheapest choice price
            if ($this->has('choices')) {
                $choicePrices = array();
                foreach($this->getChoices() as $choice) {
                    $choicePrices[] = $choice->getRecursivePrice();
                }
                asort($choicePrices);
                $price = $price + array_shift($choicePrices);
            }
        }
        return $price;
    }

    /**
     * @return parentProducts
     */
    public function getParentProducts()
    {
        return $this->parentProducts;
    }

    /**
     * @param $parentProducts
     * @return self
     */
    public function setParentProducts($parentProducts)
    {
        $this->parentProducts = $parentProducts;
        return $this;
    }

    /**
     * @return choices
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param $choices
     * @return self
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * @return images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param $images
     * @return self
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }
}
