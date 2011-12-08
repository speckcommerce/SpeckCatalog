<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_availability")
 */
class Availability
{
    /**
     * @ORM\Id
     * @ORM\Column(name="availability_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $availabilityId;

    /**
     * @ORM\ManyToOne(targetEntity="ProductUom")
     * @ORM\JoinColumn(name="product_uom_id", referencedColumnName="product_uom_id")
     */
    protected $parentProductUom;


    /**
     * @ORM\OneToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="company_id")
     */
    protected $distributor;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $cost;

    public function getQuantity()
    {
        return $this->quantity;
    }
 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
 
    public function getCost()
    {
        return $this->cost;
    }
 
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }
 
    public function getDistributor()
    {
        return $this->distributor;
    }
 
    public function setDistributor(Company $distributor=null)
    {
        $this->distributor = $distributor;
        return $this;
    }
 
    public function setAvailabilityId($availabilityId)
    {
        $this->availabilityId = $availabilityId;
        return $this;
    }
 
    public function getAvailabilityId()
    {
        return $this->availabilityId;
    }

    public function getParentProductUom()
    {
        return $this->parentProductUom;
    }

    public function setParentProductUom($parentProductUom)
    {
        $this->parentProductUom = $parentProductUom;
        return $this;
    }
}
