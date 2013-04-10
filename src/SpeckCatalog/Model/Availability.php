<?php

namespace SpeckCatalog\Model;

class Availability extends AbstractModel
{
    protected $productId;
    protected $uomCode;
    protected $distributorUomCode;
    protected $distributorItemNumber;
    protected $distributorId;
    protected $quantity;
    protected $cost;

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
     * @return distributorId
     */
    public function getDistributorId()
    {
        return $this->distributorId;
    }

    /**
     * @param $distributorId
     * @return self
     */
    public function setDistributorId($distributorId)
    {
        $this->distributorId = $distributorId;
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
     * @return cost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param $cost
     * @return self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return distributorUomCode
     */
    public function getDistributorUomCode()
    {
        return $this->distributorUomCode;
    }

    /**
     * @param $distributorUomCode
     * @return self
     */
    public function setDistributorUomCode($distributorUomCode)
    {
        $this->distributorUomCode = $distributorUomCode;
        return $this;
    }

    /**
     * @return distributorItemNumber
     */
    public function getDistributorItemNumber()
    {
        return $this->distributorItemNumber;
    }

    /**
     * @param $distributorItemNumber
     * @return self
     */
    public function setDistributorItemNumber($distributorItemNumber)
    {
        $this->distributorItemNumber = $distributorItemNumber;
        return $this;
    }

}
