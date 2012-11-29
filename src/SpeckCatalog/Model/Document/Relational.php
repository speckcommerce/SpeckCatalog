<?php

namespace Catalog\Model\Document;

use Catalog\Model\AbstractModel;
use Catalog\Model\Document as Base;

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
