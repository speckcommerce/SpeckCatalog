<?php

namespace Catalog\Model\Availability;

use Catalog\Model\Availability as Base;

class Relational extends Base
{
    protected $distributor;

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
