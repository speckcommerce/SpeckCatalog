<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM,
    SpiffyAnnotation\Form;
/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_shell")
 */
class Shell
{
    /**
     * @ORM\Id
     * @ORM\Column(name="shell_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */             
    private $shellId;

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
     * @ORM\ManyToMany(targetEntity="Option", mappedBy="Shell")
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
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="product_id", nullable=true)
     */
    protected $product;
    
    public function __construct($type=null)
    {
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

    public function setProduct(Product $product=null)
    {
        if($this->type !== 'product') {
            throw new \RuntimeException("expected type: product, type is: {$this->type}");  
        }
        $this->product = $product;
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
 
    public function setShellId($shellId)
    {
        $this->shellId = $shellId;
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

    public function getProduct()
    {
        return $this->product;
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
 
    public function getShellId()
    {
        return $this->shellId;
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
