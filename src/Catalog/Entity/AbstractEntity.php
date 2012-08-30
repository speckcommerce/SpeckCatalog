<?php

namespace Catalog\Entity;

class AbstractEntity
{
    public function has($prop)
    {
        $getter = 'get' . ucfirst($prop);
        if(method_exists($this, $getter)){
            if('s' === substr($prop, 0, -1) && is_array($this->$getter())){
                return true;
            }elseif($this->$getter()){
                return true;
            }
        }
    }

    public function __toString()
    {
        return get_class($this);
    }
}
