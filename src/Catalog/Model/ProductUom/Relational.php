<?php

namespace Catalog\Model\ProductUom;

use Catalog\Model\ProductUom as Base;

class Relational extends Base
{
    protected $availabilities;

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
