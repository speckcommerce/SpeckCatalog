<?php

namespace Catalog\Entity;

class ProductUom extends AbstractEntity
{
    protected $productId;
    protected $uomCode = 'EA';
    protected $price;
    protected $retail;
    protected $quantity = 1;
    protected $sortWeight = 0;

    //non db fields
    protected $availabilities;

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
        $this->quantity = $quantity;
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
        $this->sortWeight = $sortWeight;
        return $this;
    }

    /**
     * @return availabilities
     */
    public function getAvailabilities()
    {
        return $this->availabilities;
    }

    /**
     * @param $availabilities
     * @return self
     */
    public function setAvailabilities($availabilities)
    {
        $this->availabilities = $availabilities;
        return $this;
    }
}
