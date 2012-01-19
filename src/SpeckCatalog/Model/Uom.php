<?php

namespace SpeckCatalog\Model;

class Uom extends ModelAbstract
{
    private $uomCode;

    protected $name;

    protected $parentProductUoms;

    public function getUomCode()
    {
        return $this->uomCode;
    }
 
    public function setUomCode($uomCode)
    {
        $this->uomCode = $uomCode;
        return $this;
    }
 
    public function getName()
    {
        return $this->name;
    }
 

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
 
    public function getParentProductUoms()
    {
        return $this->parentProductUoms;
    }

    public function setParentProductUoms($parentProductUoms)
    {
        $this->parentProductUoms = $parentProductUoms;
        return $this;
    }
}
