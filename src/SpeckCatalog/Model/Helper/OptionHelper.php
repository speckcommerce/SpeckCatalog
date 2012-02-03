<?php

namespace SpeckCatalog\Model\Helper;

class OptionHelper implements OptionHelperInterface
{
    protected $option;

    public function getOption()
    {
        return $this->option;
    }

    public function setOption($option)
    {
        $this->option = $option;
        return $this;
    }  
}
