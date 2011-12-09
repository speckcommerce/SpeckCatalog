<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;
    

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_option")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\Column(name="option_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */             
    private $optionId;


    //Many to Many
    //this is the parent shell for THIS option, it may own other options... 
    //other shells may own THIS option
    protected $parentShells;
    
    /**
     * @ORM\Column(type="string")
     */   
    protected $name;
    
    /**
     * @ORM\Column(type="string")
     */   
    protected $listType = null; //radio, checkbox, dropdown,
    
    /**
     * @ORM\Column(type="string")
     */   
    protected $required = false;

    protected $selectedChoice;
    
    /**
     * @ORM\Column(type="string")
     */   
    protected $instruction;

    /**
     * @ORM\Column(type="string")
     */   
    protected $builderSegment;

    protected $choices=array();

    public function __construct($type = null)
    {
        $this->setListType($type);
    }

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
 
    private function setListType($listType)
    {
        if(!$listType){
            throw new \RuntimeException("listType not Set!");
        }
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
        $this->optionId = $optionId;
        return $this;
    }
    
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
        return $this;
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
        return $this->optionId;
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

    public function getParentShells()
    {
        return $this->parentShells;
    }

    public function setParentShells($parentShells)
    {
        $this->parentShells = $parentShells;
        return $this;
    }
}
