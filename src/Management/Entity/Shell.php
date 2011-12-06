<?php

namespace Management\Entity;

class Shell extends \Catalog\Entity\Shell
{
    protected $productId;
    protected $optionIds = array();
    protected $parentChoiceIds = array();
 
    public function getProductId()
    {
        return $this->productId;
    }
 
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
 
    public function getOptionIds()
    {
        return $this->optionIds;
    }
 
    public function setOptionIds($optionIds)
    {
        $this->optionIds = $optionIds;
        return $this;
    }
 
    public function getParentChoiceIds()
    {
        return $this->parentChoiceIds;
    }
 
    public function setParentChoiceIds($parentChoiceIds)
    {
        $this->parentChoiceIds = $parentChoiceIds;
        return $this;
    }
}
