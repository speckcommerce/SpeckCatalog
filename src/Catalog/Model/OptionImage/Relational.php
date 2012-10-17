<?php

namespace Catalog\Model\OptionImage;

use Catalog\Model\OptionImage as Base;

class Relational extends Base
{
    protected $parentId;

    public function getParentId()
    {
        return $this->optionId;
    }

    public function setParentId($parentId)
    {
        $this->optionId = $parentId;
        return $this;
    }
}
