<?php

namespace Catalog\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class AbstractHydrator extends ClassMethods implements HydratorInterface
{
    protected $unsetFields;

    public function __construct($unsetFields)
    {
        parent::__construct(true);
        $this->unsetFields = $unsetFields;
    }

    public function extract($object)
    {
        $data = parent::extract($object);
        $data = $this->unsetKeys($data);

        return $data;
    }

    public function hydrate(array $data, $object)
    {
        $data = $this->unsetKeys($data);
        return parent::hydrate($data, $object);
    }

    public function unsetKeys(array $data)
    {
        foreach($this->unsetFields as $key){
            if(array_key_exists($key, $data)){
                unset($data[$key]);
            }
        }
        return $data;
    }
}
