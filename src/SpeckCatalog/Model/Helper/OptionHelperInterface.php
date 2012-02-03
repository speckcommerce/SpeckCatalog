<?php

namespace SpeckCatalog\Model\Helper;

interface OptionHelperInterface
{
    protected $option;
    protected $name;

    public function getOption()
    {
        return $this->option;
    }

    public function setOption($option)
    {
        $this->option = $option;
        return $this;
    }
    public function help($data)
    {

    }  
}     
