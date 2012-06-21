<?php

namespace Catalog\Model\Mapper;

class Hydrator
{
    protected $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function hydrate(array $row, $model)
    {
        foreach($row as $key => $val){
            $setterMethod = 'set' . $this->toCamelCase($key);
            if(method_exists($model, $setterMethod)){
                $model->$setterMethod($val);
            }
        }
        return $model;   
    }

    public function extract($model)
    {
        $return = array();
        foreach($this->fields as $field){
            $getterMethod = 'get' . $this->toCamelCase($field);
            if(is_callable(array($model, $getterMethod))){
                $return[$field] = $model->$getterMethod();
            }
        }
        return $return;   
    }

    public static function toCamelCase($name)
    {
        return implode('', array_map('ucfirst', explode('_',$name)));
    }

    public static function fromCamelCase($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '_'.strtolower($c[1]); }, $name),'_');
    }    
}
