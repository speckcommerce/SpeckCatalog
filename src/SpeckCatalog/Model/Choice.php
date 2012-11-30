<?php

namespace SpeckCatalog\Model;

class Choice extends AbstractModel
{
    protected $choiceId;
    protected $overrideName;
    protected $productId;
    protected $optionId;
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
