<?php

namespace Catalog\Model\Option;

use Catalog\Model\Option as Base;

class Form extends Base
{
    protected $originalOptionId;

    /**
     * @return originalOptionId
     */
    public function getOriginalOptionId()
    {
        return $this->originalOptionId;
    }

    /**
     * @param $originalOptionId
     * @return self
     */
    public function setOriginalOptionId($originalOptionId)
    {
        $this->originalOptionId = $originalOptionId;
        return $this;
    }
}
