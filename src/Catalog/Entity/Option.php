<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;
    

/**
 * @ORM\Entity
 * @ORM\Table(name="shell_option")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\Column(name="option_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */             
    private $optionId;


    //one to one
    //this is the parent shell for THIS product.
    protected $shell;
    protected $shellId;

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
    protected $selectedChoiceId;
    
    /**
     * @ORM\Column(type="string")
     */   
    protected $instruction;

    /**
     * @ORM\Column(type="string")
     */   
    protected $builderSegment;

    protected $choices;
    protected $choiceIds;

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

    public function getSelectedChoiceId()
    {
        return $this->selectedChoiceId;
    }

    public function setSelectedChoiceId($selectedChoiceId)
    {
        $this->selectedChoiceId = $selectedChoiceId;
        return $this;
    }

    public function getChoiceIds()
    {
        return $this->choiceIds;
    }

    public function setChoiceIds($choiceIds)
    {
        $this->choiceIds = $choiceIds;
        return $this;
    }

    public function getShell()
    {
        return $this->shell;
    }
 
    public function setShell(Shell $shell=null)
    {
        $this->shell = $shell;
        return $this;
    }
 
    public function getShellId()
    {
        return $this->shellId;
    }
 
    public function setShellId($shellId)
    {
        $this->shellId = $shellId;
        return $this;
    }
}
