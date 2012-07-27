<?php

namespace Catalog\Model;

abstract class ModelAbstract implements ModelInterface
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

    public function get($switch)
    {
        switch($switch){
            case 'class_name':
                return join('', array_slice(explode('\\', get_class($this)), -1));
            case 'dashed_class_name':
                $dash = function($m){ return '-'.strtolower($m[1]); };
                return preg_replace_callback('/([A-Z])/', $dash, lcfirst($this->get('class_name')));
            case 'underscore_class_name':
                $underscore = function($m){ return '_'.strtolower($m[1]); };
                return preg_replace_callback('/([A-Z])/', $underscore, lcfirst($this->get('class_name')));
        }
    }
}
