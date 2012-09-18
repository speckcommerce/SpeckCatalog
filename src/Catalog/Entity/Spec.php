<?php

namespace Catalog\Entity;

class Spec extends AbstractEntity
{
    protected $specId;
    protected $productId;
    protected $label;
    protected $value;

    /**
     * @return specId
     */
    public function getSpecId()
    {
        return $this->specId;
    }

    /**
     * @param $specId
     * @return self
     */
    public function setSpecId($specId)
    {
        $this->specId = $specId;
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
     * @return label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param $label
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
