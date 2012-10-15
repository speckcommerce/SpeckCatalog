<?php

namespace Catalog\Model\OptionImage;

use Catalog\Model\OptionImage as Base;

class Relational extends Base
{
    public function getParentId()
    {
        return $this->getOptionId();
    }
}
