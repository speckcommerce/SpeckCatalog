<?php

namespace SpeckCatalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_item")
 */
class Item extends RevisionAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="item_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $itemId;

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
     * @ORM\OneToOne(targetEntity="Product", mappedBy="Product")  
     */
    protected $parentProduct;

    /**
     * @ORM\Column(name="hcpcs", type="string")
     */
    protected $hcpcs;
    
    /**
     * @ORM\Column(name="item_number", type="string")
     */
    protected $itemNumber;

    /**
     * @ORM\ManyToOne(targetEntity="ProductUom")
     * @ORM\JoinColumn(name="product_uom_id", referencedColumnName="product_uom_id")
     */
    protected $uoms;

    public function addUom(ItemUom $uom)
    {
        $this->uoms[] = $uom;
        return $this;
    }
    public function setUoms($uoms=null)
    {
        $this->uoms = array();
        if(is_array($uoms)){
            foreach($uoms as $uom){
                $this->addUom($uom);
            }
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
 
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
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

    public function getItemId()
    {
        return $this->itemId;
    }
    public function getHcpcs()
    {
        return $this->hcpcs;
    }
 
    public function getParentProduct()
    {
        return $this->parentProduct;
    }

    public function setParentProduct(Product $parentProduct)
    {
        $this->parentProduct = $parentProduct;
        return $this;
    }
 
    /**
     * Get itemNumber.
     *
     * @return itemNumber
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }
 
    /**
     * Set itemNumber.
     *
     * @param $itemNumber the value to be set
     */
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }
}
