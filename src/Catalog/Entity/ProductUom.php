<?php

namespace SwmBase\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_uom")
 */
class ProductUom
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_uom_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $productUomId;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     */
    protected $product;
    
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

    protected $productId;
    protected $availabilityIds;

    
 
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
 
    public function setProduct(Product $product=null)
    {
        $this->product = $product;
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
    public function getProduct()
    {
        return $this->product;
    }
 
    /**
     * Get quantity.
     *
     * @return quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
 
    /**
     * Set quantity.
     *
     * @param $quantity the value to be set
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
}
