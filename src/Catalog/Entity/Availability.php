<?php

namespace SwmBase\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="availability")
 */
class Availability
{
    /**
     * @ORM\Id
     * @ORM\Column(name="availability_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $availabilityId;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="ProductUom")
     * @ORM\JoinColumn(name="product_uom_id", referencedColumnName="product_uom_id")
     */
    protected $productUom;


    /**
     * @ORM\OneToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="company_id")
     */
    protected $distributor;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $cost;

 
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
 
    /**
     * Get cost.
     *
     * @return cost
     */
    public function getCost()
    {
        return $this->cost;
    }
 
    /**
     * Set cost.
     *
     * @param $cost the value to be set
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }
 
    /**
     * Get distributor.
     *
     * @return distributor
     */
    public function getDistributor()
    {
        return $this->distributor;
    }
 
    /**
     * Set distributor.
     *
     * @param $distributor the value to be set
     */
    public function setDistributor(Company $distributor)
    {
        $this->distributor = $distributor;
        return $this;
    }
 
    /**
     * Set availabilityId.
     *
     * @param $availabilityId the value to be set
     */
    public function setAvailabilityId($availabilityId)
    {
        $this->availabilityId = $availabilityId;
        return $this;
    }
 
    /**
     * Get availabilityId.
     *
     * @return availabilityId
     */
    public function getAvailabilityId()
    {
        return $this->availabilityId;
    }
 
    /**
     * Get productUom.
     *
     * @return productUom
     */
    public function getProductUom()
    {
        return $this->productUom;
    }
 
    /**
     * Set productUom.
     *
     * @param $productUom the value to be set
     */
    public function setProductUom(ProductUom $productUom)
    {
        $this->productUom = $productUom;
        return $this;
    }
 
    /**
     * Get product.
     *
     * @return product
     */
    public function getProduct()
    {
        return $this->product;
    }
 
    /**
     * Set product.
     *
     * @param $product the value to be set
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }
}
