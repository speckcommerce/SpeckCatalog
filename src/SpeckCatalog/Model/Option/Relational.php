<?php

namespace SpeckCatalog\Model\Option;

use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Model\Option as Base;
use SpeckCatalog\Model\Product\Relational as RelationalProduct;
use SpeckCatalog\Model\Choice\Relational as RelationalChoice;

class Relational extends Base
{
    protected $parent;
    protected $parentProducts;
    protected $choices;
    protected $images;
    protected $productId; //parent product id
    protected $choiceId; //parent choice id

    public function getKey()
    {
        return $this->optionId;
    }

    public function getRecursivePrice($parentProductPrice = 0, $retailPrice = false)
    {
        if ($this->getRequired()) {
            if ($this->has('choices')) {
                $choicePrices = array();
                foreach ($this->getChoices() as $choice) {
                    $choicePrices[] = $choice->getRecursivePrice($parentProductPrice, $retailPrice);
                }

                asort($choicePrices, SORT_NUMERIC);
                return array_shift($choicePrices) ?: 0;
            }
        }

        return 0;
    }


    public function getAdjustedPrice($retailPrice = false)
    {
        $parent = $this->getParent();
        if ($parent instanceof RelationalProduct) {
            return $parent->getPrice($retailPrice);
        } else {
            if (isset($parent)) {
                return $parent->getAdjustedPrice($retailPrice);
            } else {
                return 0;
            }
        }
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

        if ($parent instanceof RelationalProduct) {
            $this->setProductId($parent->getProductId());
        } elseif ($parent instanceof RelationalChoice) {
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
        if ($this->getName()) {
            return $this->getName();
        } else {
            return 'Unnamed Option Group';
        }
    }

    public function getListType()
    {
        switch ($this->optionTypeId) {
            case 1:
                return 'dropdown';
            case 2:
                return 'radio';
            case 3:
                return 'checkbox';
        }

    }
}
