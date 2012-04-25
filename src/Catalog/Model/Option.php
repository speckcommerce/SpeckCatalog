<?php

namespace Catalog\Model;
use Exception;

class Option extends ModelAbstract
{
    protected $optionId;

    protected $parentProducts;
    protected $parentChoices;
    
    protected $name;
    
    protected $listType = null; //radio, checkbox, dropdown, slider

    protected $slider;
    
    protected $required = false;

    protected $instruction;

    protected $builderSegment;

    protected $choices;

    protected $priceMap;

    protected $choiceUomAdjustments;
    
    /* Linker */
    protected $linkerId;
    protected $sortWeight; 


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
 
    public function setOptionId($optionId)
    {
        $this->optionId = (int) $optionId;
        return $this;
    }
    
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
        return $this;
    }

    public function hasChoices()
    {
        if($this->getChoices() && count($this->getChoices()) > 0){
            return true;
        }
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

    public function getOptionId()
    {
        return (int) $this->optionId;
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
            $return  = $this->getName();
        }else{
            $return  = '';
        }
        return $this->spaceToNbsp($return);
    }
    
    public function getId()
    {
        return $this->getOptionId();
    }

    public function setId($id)
    {
        return $this->setOptionId($id);
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
 
    public function getLinkerId()
    {
        return $this->linkerId;
    }
 
    public function setLinkerId($linkerId)
    {
        $this->linkerId = $linkerId;
        return $this;
    }

    public function getSortWeight()
    {
        return $this->sortWeight;
    }

    public function setSortWeight($sortWeight)
    {
        $this->sortWeight = $sortWeight;
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
}
