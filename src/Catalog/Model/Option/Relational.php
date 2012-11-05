<?php

namespace Catalog\Model\Option;

use Catalog\Model\AbstractModel;
use Catalog\Model\Option as Base;
use Catalog\Model\Product\Relational as RelationalProduct;
use Catalog\Model\Choice\Relational as RelationalChoice;

class Relational extends Base
{
    protected $parent;
    protected $parentProducts;
    protected $choices;
    protected $images;
    protected $productId;
    protected $choiceId;

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

    public function addChoice($choice)
    {
        $choice->setParent($this);
        $this->choices[] = $choice;
        return $this;
    }

    /**
     * @param $choices
     * @return self
     */
    public function setChoices($choices)
    {
        $this->choices = array();

        foreach ($choices as $choice) {
            $this->addChoice($choice);
        }

        return $this;
    }

    /**
     * @return images
     */
    public function getImages()
    {
        return $this->images;
    }

    public function addImage($image)
    {
        $image->setParent($this);
        $this->images[] = $image;
        return $this;
    }

    /**
     * @param $images
     * @return self
     */
    public function setImages($images)
    {
        $this->images = array();

        foreach ($images as $image) {
            $this->addImage($image);
        }

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

        if ($parent instanceOf RelationalProduct) {
            $this->setProductId($parent->getProductId());
        } elseif ($parent instanceOf RelationalChoice) {
            $this->setChoiceId($parent->getChoiceId());
        }

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

    public function __toString()
    {
        if($this->getName()) {
            return $this->getName();
        } else {
            return 'Unnamed Option Group';
        }
    }
}
