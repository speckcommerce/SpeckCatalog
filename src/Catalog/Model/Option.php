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

    /**
     * listType
     *
     * @var string
     * @access protected
     */
    protected $listType = 'radio'; //radio, checkbox, dropdown, slider

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

    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    public function setListType($listType=null)
    {
        if($listType !== 'radio' && $listType !== 'dropdown' && $listType !== 'checkbox'){
            throw new \InvalidArgumentException("invalid list type - '{$listType}', must be 'radio', 'dropdown' or 'checkbox'");
        }
        $this->listType = $listType;
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

    public function getListTypes()
    {
        return array('radio', 'checkbox', 'dropdown');
    }

    public function getName()
    {
        return $this->name;
    }

    public function getChoices()
    {
        //$this->events()->trigger(__FUNCTION__, $this, array('choices' => $this->choices));
        return $this->choices;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function getListType()
    {
        return $this->listType;
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

    public function getSlider()
    {
        return $this->slider;
    }

    public function setSlider($slider)
    {
        if('slider' === $this->getType()){
            $this->slider = $slider;
        }
        return $this;
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

 /**
  * Get optionId.
  *
  * @return optionId.
  */
 function getOptionId()
 {
     return $this->optionId;
 }

 /**
  * Set optionId.
  *
  * @param optionId the value to set.
  */
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
}
