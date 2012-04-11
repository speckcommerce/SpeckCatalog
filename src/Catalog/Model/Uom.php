<?php

namespace Catalog\Model;

class Uom extends ModelAbstract
{
    private $uomCode;

    protected $name;

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

    public function __toString()
    {
        return $this->name . ' (' . $this->uomCode . ')';
    }
    public function getId()
    {
        return $this->getUomCode();
    }
    public function setId($id)
    {
        return $this->setUomCode($id);
    }
}
