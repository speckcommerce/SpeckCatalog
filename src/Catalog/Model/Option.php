<?php

namespace Catalog\Model;
use Exception;

class Option extends LinkedModelAbstract
{
    protected $optionId;

    /**
     * parentProducts
     *
     * @var array
     * @access protected
     */
    protected $parentProducts;

    /**
     * parentChoices
     *
     * @var array
     * @access protected
     */
    protected $parentChoices;

    /**
     * name
     *
     * @var string
     * @access protected
     */
    protected $name;

    protected $variation = 0;

    protected $optionTypeId = 1;

    protected $slider;

    /**
     * required
     *
     * @var bool
     * @access protected
     */
    protected $required = false;

    /**
     * instruction
     *
     * @var string
     * @access protected
     */
    protected $instruction;

    protected $builderSegment;

    /**
     * images
     *
     * @var array
     * @access protected
     */
    protected $images;

    /**
     * choices
     *
     * @var array
     * @access protected
     */
    protected $choices;

    protected $priceMap;

    protected $choiceUomAdjustments;

    public function addChoice(Choice $choice)
    {
        $this->choices[] = $choice;
        return $this;
    }

    public function setChoices($choices)
    {
        $this->choices = array();
        if(is_array($choices)){
            foreach($choices as $choice){
                $this->addChoice($choice);
            }
        }
        return $this;
    }

    public function getRecursivePrice()
    {
        $price = 0;
        if ($this->getRequired()) {
            //add the cheapest choice price
            if ($this->has('choices')) {
                $choicePrices = array();
                foreach($this->getChoices() as $choice) {
                    $choicePrices[] = $choice->getRecursivePrice();
                }
                asort($choicePrices);
                $price = $price + array_shift($choicePrices);
            }
        }
        return $price;
    }

    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
        return $this;
    }

    public function isShared()
    {
        if($this->shareCount() > 1){
            return true;
        }
    }

    public function shareCount()
    {
        $count = 0;
        if($this->getParentProducts()){
            $count = $count + count($this->getParentProducts());
        }
        if($this->getParentChoices()){
            $count = $count + count($this->getParentChoices());
        }
        return $count;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getChoices()
    {
        return $this->choices;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function getInstruction()
    {
        return $this->instruction;
    }

    public function getParentProducts()
    {
        return $this->parentProducts;
    }

    public function setParentProducts($parentProducts)
    {
        $this->parentProducts = $parentProducts;
        return $this;
    }

    public function __toString()
    {
        if($this->getName()){
            return  $this->getName();
        }else{
            return  '';
        }
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

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    function getOptionId()
    {
        return $this->optionId;
    }

    function setOptionId($optionId)
    {
        $this->optionId = $optionId;
        return $this;
    }

    public function getId()
    {
        return $this->optionId;
    }

    public function setId($id)
    {
        return $this->setOptionId($id);
    }

    function getVariation()
    {
        return $this->variation;
    }

    function setVariation($variation)
    {
        $this->variation = $variation;
    }

    public function getOptionTypeId()
    {
        return $this->optionTypeId;
    }

    public function setOptionTypeId($optionTypeId)
    {
        if($optionTypeId > 3){
            throw new \Exception('invalid option type id');
        }
        $this->optionTypeId = $optionTypeId;
        return $this;
    }
}
