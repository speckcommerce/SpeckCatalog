<?php

namespace SpeckCatalog\Model\Builder;

use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Model\Choice\Relational as Choice;
use SpeckCatalog\Model\Product\Relational as Product;
/*
 * this model does not extend another model
 * because it doesnt not have a db table
 * associated directly with it, many rows from the linker table make up one "builder"
 */
class Relational extends AbstractModel
{
    protected $choices;

    protected $product;

    protected $parent;

    protected $parentProductId;

    protected $productId;

    protected $options;

    //option_id => choice_id
    protected $selected = array();

    public function getChoices()
    {
        return $this->choices;
    }

    public function addChoice(Choice $choice)
    {
        $this->choices[] = $choice;
        return $this;
    }

    public function setChoices(array $choices = array())
    {
        $this->choices = array();
        foreach ($choices as $choice) {
            $this->addChoice($choice);
        }
        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->setProductId($product->getProductId());
        $this->product = $product;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->setParentProductId($parent->getProductId());
        $this->parent = $parent;
        return $this;
    }

    public function getParentProductId()
    {
        return $this->parentProductId;
    }

    public function setParentProductId($parentProductId)
    {
        $this->parentProductId = $parentProductId;
        return $this;
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

    public function getOptions()
    {
        return $this->options;
    }

    public function addOption($option)
    {
        $this->options[] = $option;
        return $this;
    }

    public function setOptions($options)
    {
        $this->options = array();
        foreach ($options as $option) {
            $this->addOption($option);
        }
        return $this;
    }

    public function getSelected()
    {
        return $this->selected;
    }

    public function addSelected($optionId, $choiceId)
    {
        $this->selected[$optionId] = (int) $choiceId;
    }

    public function setSelected(array $selected = null)
    {
        $this->selected = array();
        if (!is_array($selected)) {
            return $this;
        }
        foreach ($selected as $optionId => $choiceId) {
            $this->addSelected($optionId, $choiceId);
        }
        return $this;
    }
}
