<?php

namespace Management\Entity;

class Option extends \Catalog\Entity\Option
{
    protected $parentShellId;
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
 
    public function getParentShellId()
    {
        return $this->parentShellId;
    }
 
    public function setParentShellId($parentShellId)
    {
        $this->parentShellId = $parentShellId;
        return $this;
    }   

    public function deflate()
    {
        $shell = $this->getParentShell();
        if($shell){
            $this->setParentShellId($shell->getShellId());
        }
        $this->setParentShell(null);
        
        $choice = $this->getSelectedChoice();
        if($choice){
            $this->setSelectedChoiceId($choice);
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
        return $this;
    }   
}
