<?php

namespace SpeckCatalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_uom")
 */
class Uom 
{
    /**
     * @ORM\Id
     * @ORM\Column(name="uom_code", type="string", length=2)
     */
    private $uomCode;

    /**
     * @ORM\Column(type="string", length=32)
     */
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
