<?php

namespace Catalog\Model\ProductUom;

use Catalog\Model\ProductUom as Base;

class Form extends Base
{
    protected $originalProductId;
    protected $originalUomCode;
    protected $originalQuantity;

    /**
     * @return originalProductId
     */
    public function getOriginalProductId()
    {
        return $this->originalProductId;
    }

    /**
     * @param $originalProductId
     * @return self
     */
    public function setOriginalProductId($originalProductId)
    {
        $this->originalProductId = $originalProductId;
        return $this;
    }

    /**
     * @return originalUomCode
     */
    public function getOriginalUomCode()
    {
        return $this->originalUomCode;
    }

    /**
     * @param $originalUomCode
     * @return self
     */
    public function setOriginalUomCode($originalUomCode)
    {
        $this->originalUomCode = $originalUomCode;
        return $this;
    }

    /**
     * @return originalQuantity
     */
    public function getOriginalQuantity()
    {
        return $this->originalQuantity;
    }

    /**
     * @param $originalQuantity
     * @return self
     */
    public function setOriginalQuantity($originalQuantity)
    {
        $this->originalQuantity = $originalQuantity;
        return $this;
    }
}
