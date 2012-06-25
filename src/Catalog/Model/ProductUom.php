<?php

namespace Catalog\Model;

class ProductUom extends ModelAbstract
{
    /**
     * productUomId
     *
     * @var int
     * @access protected
     */
    protected $productUomId;

    /**
     * uom
     *
     * @var object Catalog\Model\Uom
     * @access protected
     */
    protected $uom;

    /**
     * uomCode
     *
     * @var string
     * @access protected
     */
    protected $uomCode = 'EA';

    /**
     * uoms
     *
     * @var array
     * @access protected
     */
    protected $uoms;

    /**
     * parentProduct
     *
     * @var object Catalog\Model\Product
     * @access protected
     */
    protected $parentProduct;

    /**
     * parentProductId
     *
     * @var int
     * @access protected
     */
    protected $parentProductId;

    /**
     * quantity
     *
     * @var int
     * @access protected
     */
    protected $quantity = 1;

    /**
     * price
     *
     * @var float
     * @access protected
     */
    protected $price = 0;

    /**
     * retail
     *
     * @var float
     * @access protected
     */
    protected $retail = 0;

    /**
     * availabilities
     *
     * @var array
     * @access protected
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
        $this->price = (float) $price;
        return $this;
    }

    public function setRetail($retail)
    {

        $this->retail = (float) $retail;
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

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
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

    public function getProductUomId()
    {
        return $this->productUomId;
    }

    public function setProductUomId($productUomId)
    {
        $this->productUomId = (int)$productUomId;
        return $this;
    }

    public function getParentProductId()
    {
        return $this->parentProductId;
    }

    public function setParentProductId($parentProductId)
    {
        $this->parentProductId = (int) $parentProductId;
        return $this;
    }

    public function setUomCode($uomCode)
    {
        $this->uomCode = $uomCode;
        return $this;
    }

    public function getUomCode()
    {
        return $this->uomCode;
    }

    public function __toString()
    {
        return $this->getUom()->__toString()
            . ' ' . $this->getQuantity()
            . ' - $' . number_format($this->getPrice(), 2);
    }

    public function getUoms()
    {
        return $this->uoms;
    }

    public function setUoms($uoms)
    {
        $this->uoms = $uoms;
        return $this;
    }
    public function getId()
    {
        return $this->getProductUomId();
    }

    public function setId($id)
    {
        return $this->setProductUomId($id);
    }
}
