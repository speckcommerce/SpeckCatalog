<?php

namespace SpeckCatalog\Model\OptionImage;

use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Model\OptionImage as Base;

class Relational extends Base
{
    protected $parent;
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
