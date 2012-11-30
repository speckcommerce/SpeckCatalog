<?php

namespace SpeckCatalog\Model\Spec;

use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Model\Spec as Base;

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

        $this->setProductId($parent->getProductId());

        return $this;
    }
}
