<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="uom")
 */
class Uom 
{
    /**
     * @ORM\Id
     * @ORM\Column(name="uom_code", type="string", length=2)
     */
    protected $uomCode;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $name;
}
