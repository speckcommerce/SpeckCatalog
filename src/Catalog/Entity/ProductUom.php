<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_product_uom")
 */
class ProductUom
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_uom_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $productUomId;

    protected $uom;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="Product")
     */
    protected $parentProduct;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $price;
    /**
     * @ORM\Column(type="decimal")
     */
    protected $retail;

    /**
     * @ORM\OneToMany(targetEntity="Availability", mappedBy="productUom")
     * @ORM\JoinColumn(name="availability_id", referencedColumnName="availability_id")
     */
    protected $availabilities;


 
    public function addAvailability(Availability $availability)
    {
        $this->availabilities[] = $availability;
        return $this;
    }
    public function setAvailabilities($availabilities)
    {
        $this->availabilities = array();
        foreach($availabilities as $availability){
            $this->addAvailability($availability);
        }
        return $this;
    }
 
    public function setPrice($price)
    {
        if(!is_float($price)){ 
            throw new \InvalidArgumentException("price must be float - '{$price}'");
        }  
        $this->price = $price;
        return $this;
    }

    public function setRetail($retail)
    {
        if(!is_float($retail)){ 
            throw new \InvalidArgumentException("price must be float - '{$retail}'");
        }
        $this->retail = $retail;
        return $this;
    }
 
    public function setProductUomId($productUomId)
    {
        $this->productUomId = $productUomId;
        return $this;
    }

    public function getRetail()
    {
        return $this->retail;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getAvailabilities()
    {
        return $this->availabilities;
    }
    public function getProductUomId()
    {
        return $this->productUomId;
    }
 
    public function getQuantity()
    {
        return $this->quantity;
    }
 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
 
    public function getUom()
    {
        return $this->uom;
    }
 
    public function setUom(Uom $uom)
    {
        $this->uom = $uom;
        return $this;
    }
 
    public function getParentProduct()
    {
        return $this->parentProduct;
    }
 
    public function setParentProduct(Product $parentProduct=null)
    {
        $this->parentProduct = $parentProduct;
        return $this;
    }
}
