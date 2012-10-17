<?php

namespace Catalog\Model\ProductImage;

use Catalog\Model\ProductImage as Base;

class Relational extends Base
{

    public function getParentId()
    {
        return $this->productId;
    }

    public function setParentId($parentId)
    {
        $this->productId = $parentId;
        return $this;
    }
}
