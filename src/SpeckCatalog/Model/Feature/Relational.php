<?php

namespace Catalog\Model\Feature;

use Catalog\Model\AbstractModel;
use Catalog\Model\Feature as Base;

class Relational extends Base
{
    protected $parent;

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
        return $this;
    }
}
