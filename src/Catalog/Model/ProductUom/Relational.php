<?php

namespace Catalog\Model\ProductUom;

use Catalog\Model\ProductUom as Base;

class Relational extends Base
{
    protected $availabilities;
    protected $uom;

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
        $this->uom = $uom;
        return $this;
    }
}
