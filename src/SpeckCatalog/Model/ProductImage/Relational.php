<?php

namespace Catalog\Model\ProductImage;

use Catalog\Model\AbstractModel;
use Catalog\Model\ProductImage as Base;

class Relational extends Base
{
    protected $parent;

    public function getParentId()
    {
        return $this->productId;
    }

    public function setParentId($parentId)
    {
        $this->productId = $parentId;
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
        return $this;
    }
}
