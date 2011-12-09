<?php

namespace Management\Entity;

class Option extends \Catalog\Entity\Option
{
    protected $parentShellIds;
    protected $selectedChoiceId;
    protected $choiceIds;
 
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
 
    public function getParentShellIds()
    {
        return $this->parentShellIds;
    }
 
    public function setParentShellIds($parentShellIds)
    {
        $this->parentShellIds = $parentShellIds;
        return $this;
    }   

    public function deflate()
    {
        $parentShellIds = array();
        if(count($this->getParentShells()) > 0){
            foreach($this->getParentShells() as $shell){
                $parentShellIds[] = $shell->getShellId();
            }
        }
        $this->setParentShellIds($parentShellIds);
        $this->setParentShells(null);  
        
        $choice = $this->getSelectedChoice();
        if($choice){
            $this->setSelectedChoiceId($choice->getChoiceId());
        }
        $this->setSelectedChoice(null);

        $choiceIds = array();
        if(count($this->getChoices()) > 0){
            foreach($this->getChoices() as $choice){
                $choiceIds[] = $choice->getChoiceId();
            }
        }
        $this->setChoiceIds($choiceIds);
        $this->setChoices(null);
    }   
}
