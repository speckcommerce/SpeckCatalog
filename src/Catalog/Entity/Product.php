<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $productId;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="manufacutrer_id", referencedColumnName="company_id")
     */
    protected $manufacturer;

    /**
     * @ORM\Column(name="hcpcs", type="string")
     */
    protected $hcpcs;
    
    /**
     * @ORM\Column(name="part_number", type="string")
     */
    protected $partNumber;

    /**
     * @ORM\OneToMany(targetEntity="ProductUom", mappedBy="product")
     */
    protected $uoms;

    public function addUom(ProductUom $uom)
    {
        $this->uoms[] = $uom;
        return $this;
    }
    public function setUoms($uoms)
    {
        $this->uoms = array();
        foreach($uoms as $uom){
            $this->addUom($uom);
        }
        return $this;
    }
 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
 
    public function setManufacturer(Company $manufacturer=null)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }
 
 
    public function setPartNumber($partNumber)
    {
        $this->partNumber = $partNumber;
        return $this;
    }
 
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
 
    public function setHcpcs($hcpcs)
    {
        $this->hcpcs = $hcpcs;
        return $this;
    }
    
    
    public function getName()
    {
        return $this->name;
    }
    public function getManufacturer()
    {
        return $this->manufacturer;
    }
    public function getUoms()
    {
        return $this->uoms;
    }
    public function getPartNumber()
    {
        return $this->partNumber;
    }
    public function getProductId()
    {
        return $this->productId;
    }
    public function getHcpcs()
    {
        return $this->hcpcs;
    }
}
