<?php

namespace SpeckCatalog\Model;

class Option extends ModelAbstract
{
    private $optionId;

    protected $parentProducts;
    
    protected $name;
    
    protected $listType = null; //radio, checkbox, dropdown,
    
    protected $required = false;

    protected $selectedChoice;
    
    protected $instruction;

    protected $builderSegment;

    protected $choices=array();

    public function addChoice(Choice $choice)
    {
        $this->choices[] = $choice;
        return $this;
    }

    public function setChoices($choices)
    {
        $this->selectedChoice = null; // this must reset the selected choice.
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
        if($this->listType !== "radio" && $this->listType !== 'dropdown'){
            throw new \RuntimeException("invalid listType - '{$this->listType}', must be 'radio' or 'dropdown'");
        }
        if(!is_bool($required)){
            throw new \InvalidArgumentException("invalid required value '{$required}', expected boolean");
        }
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
    
    public function setSelectedChoice(Choice $choice=null)
    {
        if ($this->listType !== 'radio'){ 
            throw new \RuntimeException("invalid type! - '{$this->listType}', must be 'radio'");
        }
        if($choice){
            if(count($this->choices) === 0){
                throw new \RuntimeException('there are no choices');
            }
            $choiceIds = array();
            foreach($this->choices as $currentChoice){
                $choiceIds[] = $currentChoice->getChoiceId();
            }
            if(!in_array($choice->getChoiceId(), $choiceIds)){
                throw new \RuntimeException('choice not in choices');
            }
        } 
        $this->selectedChoice = $choice;
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
        if($this->getParentProducts() && count($this->getParentProducts) > 1){
            return true;
        }
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
        return $this->choices;
    }
    public function getRequired()
    {
        return $this->required;
    }
    public function getOptionId()
    {
        return (int)$this->optionId;
    }
    public function getListType()
    {
        return $this->listType;
    }
    public function getInstruction()
    {
        return $this->instruction;
    } 
    public function getSelectedChoice()
    {
        return $this->selectedChoice;
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
    public function __toString(){
        if($this->getName()){
            return $this->getName();
        }else{
            return '';
        }
    }
}
