<?php

namespace SpeckCatalog\Model;

class Choice extends AbstractModel
{
    protected $choiceId;
    protected $overrideName;
    protected $productId;
    protected $optionId;
    protected $priceOverrideFixed;
    protected $priceDiscountFixed;
    protected $priceDiscountPercent;
    protected $priceNoCharge = 0;
    protected $sortWeight = 0;

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

    /**
     * @return overrideName
     */
    public function getOverrideName()
    {
        return $this->overrideName;
    }

    /**
     * @param $overrideName
     * @return self
     */
    public function setOverrideName($overrideName)
    {
        $this->overrideName = $overrideName;
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
     * @return priceOverrideFixed
     */
    public function getPriceOverrideFixed()
    {
        return $this->priceOverrideFixed;
    }

    /**
     * @param $priceOverrideFixed
     * @return self
     */
    public function setPriceOverrideFixed($priceOverrideFixed)
    {
        $this->priceOverrideFixed = $priceOverrideFixed;
        return $this;
    }

    /**
     * @return priceDiscountFixed
     */
    public function getPriceDiscountFixed()
    {
        return $this->priceDiscountFixed;
    }

    /**
     * @param $priceDiscountFixed
     * @return self
     */
    public function setPriceDiscountFixed($priceDiscountFixed)
    {
        $this->priceDiscountFixed = $priceDiscountFixed;
        return $this;
    }

    /**
     * @return priceDiscountPercent
     */
    public function getPriceDiscountPercent()
    {
        return $this->priceDiscountPercent;
    }

    /**
     * @param $priceDiscountPercent
     * @return self
     */
    public function setPriceDiscountPercent($priceDiscountPercent)
    {
        $this->priceDiscountPercent = $priceDiscountPercent;
        return $this;
    }

    /**
     * @return priceNoCharge
     */
    public function getPriceNoCharge()
    {
        return $this->priceNoCharge;
    }

    /**
     * @param $priceNoCharge
     * @return self
     */
    public function setPriceNoCharge($priceNoCharge)
    {
        $this->priceNoCharge = (bool)$priceNoCharge;
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
}
