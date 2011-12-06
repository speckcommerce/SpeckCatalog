<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shell")
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
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
      */
    protected $description;
    
    protected $type = null;  //will be('shell', 'product', 'builder')
    
    
    //protected $features;
    
    //protected $attributes;
    
    /**
     * @ORM\OneToMany(targetEntity="Option", mappedBy="shell")
     */
    protected $options;

    protected $price = 0;

    protected $parentChoices = array();
/**
 * only when shell type is 'product' 
 */

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

    public function getOptionIds()
    {
        return $this->optionIds;
    }

    public function setOptionIds($optionIds)
    {
        $this->optionIds = $optionIds;
        return $this;
    }
 
    public function getProductId()
    {
        return $this->productId;
    }
 
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
}
