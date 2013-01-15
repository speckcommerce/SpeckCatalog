<?php

namespace SpeckCatalog\Model;

class ProductUom extends AbstractModel
{
    protected $productId;
    protected $uomCode;
    protected $price;
    protected $retail;
    protected $quantity;
    protected $sortWeight;

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
        $this->productId = (int) $productId;
        return $this;
    }

    /**
     * @return uomCode
     */
    public function getUomCode()
    {
        return $this->uomCode;
    }

    /**
     * @param $uomCode
     * @return self
     */
    public function setUomCode($uomCode)
    {
        $this->uomCode = $uomCode;
        return $this;
    }

    /**
     * @return price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return retail
     */
    public function getRetail()
    {
        return $this->retail;
    }

    /**
     * @param $retail
     * @return self
     */
    public function setRetail($retail)
    {
        $this->retail = $retail;
        return $this;
    }

    /**
     * @return quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
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
        $this->sortWeight = (int) $sortWeight;
        return $this;
    }
}
