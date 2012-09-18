<?php

namespace Catalog\Entity;

class Availability extends AbstractEntity
{
    protected $productId;
    protected $uomCode;
    protected $distributorId;
    protected $cost;
    protected $quantity;


    //non db fields
    protected $distributor;

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
     * @return distributor
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * @param $distributor
     * @return self
     */
    public function setDistributor($distributor)
    {
        $this->distributor = $distributor;
        return $this;
    }
}
