<?php

namespace SpeckCatalog\Entity;

use Doctrine\ORM\Mapping AS ORM,
    SpiffyAnnotation\Form;
/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_product")
 */
class Product extends RevisionAbstract
{
    /**
     * @ORM\Id
     * @ORM\Column(name="product_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */             
    private $productId;

     /**
     * @ORM\Column(type="string")
     * @Form\Element(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
    */
    protected $description;
    
    /**
     * @ORM\Column(type="string", length=16)
     */
    protected $type = null;  //will be('shell', 'product', 'builder')
    
    //protected $features;
    
    //protected $attributes;
    
    /**
     * @ORM\ManyToMany(targetEntity="Option", mappedBy="product")
     */
    protected $options;

    /**
     * @ORM\Column(type="float")
     * @Form\Element(type="float")
     */
    protected $price = 0;

    /**
     * @ORM\ManyToMany(targetEntity="Choice", mappedBy="Choice")
     */
    protected $parentChoices = array();

    /**
     * @ORM\OneToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="item_id", nullable=true)
     */
    protected $item;
    
    public function __construct($type=null)
    {
        if(!$type){
            $type = 'shell';
        }
        $this->setType($type);
    }

    private function setType($type)
    {
        if($type === null) {
            throw new \RuntimeException("no type specified! '{$this->type}'");  
        }
        if($type !== 'shell' && $type !== 'product' && $type !== 'builder'){
            throw new \InvalidArgumentException("invalid type, must be 'shell', 'product', or 'builder'");
        }
        $this->type = $type;
        return $this;
    }

    public function setItem(Item $item=null)
    {
        if($this->type !== 'product') {
            throw new \RuntimeException("expected type: product, type is: {$this->type}");  
        }
        $this->item = $item;
        return $this;
    }

    public function addOption(Option $option)
    {
        $this->options[] = $option;
        return $this;
    }

    public function setOptions($options)
    {
        $this->options = array();
        if(is_array($options)){
            foreach($options as $option){
                $this->addOption($option);
            }
        }
        return $this;
    }
 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
 
    public function setProductId($productId)
    {
        $this->productId = $productId;
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

    public function getItem()
    {
        return $this->item;
    }

    public function getOptions()
    {
        return $this->options;
    }
 
    public function getName()
    {
        return $this->name;
    }
 
    public function getDescription()
    {
        return $this->description;
    }
 
    public function getProductId()
    {
        return $this->productId;
    }
 
    public function getType()
    {
        return $this->type;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getParentChoices()
    {
        return $this->parentChoices;
    }
 
    public function setParentChoices($parentChoices)
    {
        $this->parentChoices = $parentChoices;
        return $this;
    }
}
