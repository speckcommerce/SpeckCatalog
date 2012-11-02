<?php

namespace Catalog\Model\ProductUom;

use Catalog\Model\AbstractModel;
use Catalog\Model\ProductUom as Base;

class Relational extends Base
{
    protected $parent;
    protected $availabilities;
    protected $uom;

    /**
     * @return availabilities
     */
    public function getAvailabilities()
    {
        return $this->availabilities;
    }

    public function addAvailability($availability)
    {
        $availability->setParent($this);
        $this->availabilities[] = $availability;
        return $this;
    }

    /**
     * @param $availabilities
     * @return self
     */
    public function setAvailabilities($availabilities)
    {
        $this->availabilities = array();

        foreach ($availabilities as $availability) {
            $this->addAvailability($availability);
        }

        return $this;
    }

    /**
     * @return uom
     */
    public function getUom()
    {
        return $this->uom;
    }

    /**
     * @param $uom
     * @return self
     */
    public function setUom($uom)
    {
        $uom->setParent($this);
        $this->uom = $uom;
        return $this;
    }

    /**
     * @return parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param $parent
     * @return self
     */
    public function setParent(AbstractModel $parent)
    {
        $this->parent = $parent;

        $this->setProductId($parent->getProductId());

        return $this;
    }

    public function __toString()
    {
        if($this->getUom()) {
            $string  = $this->getPrice() . ' - ';
            $string .= $this->getUom()->getName();
            $string .= ' (' . $this->getUomCode() . ')';
            $string .= ' of ' . $this->getQuantity();
        } else {
            $string = 'Incomplete ProductUom';
        }
        return $string;
    }
}
