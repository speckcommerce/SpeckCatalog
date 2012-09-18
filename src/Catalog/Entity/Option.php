<?php

namespace Catalog\Entity;

class Option extends AbstractEntity
{
    protected $optionId;
    protected $name;
    protected $instruction;
    protected $required;
    protected $optionTypeId;
    protected $variation = 0;

    //non db fields
    protected $parentProducts;
    protected $choices;

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
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return instruction
     */
    public function getInstruction()
    {
        return $this->instruction;
    }

    /**
     * @param $instruction
     * @return self
     */
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
        return $this;
    }

    /**
     * @return required
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param $required
     * @return self
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return optionTypeId
     */
    public function getOptionTypeId()
    {
        return $this->optionTypeId;
    }

    /**
     * @param $optionTypeId
     * @return self
     */
    public function setOptionTypeId($optionTypeId)
    {
        $this->optionTypeId = $optionTypeId;
        return $this;
    }

    /**
     * @return variation
     */
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * @param $variation
     * @return self
     */
    public function setVariation($variation)
    {
        $this->variation = $variation;
        return $this;
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

    public function __toString()
    {
        return '' . $this->getName();
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
}
