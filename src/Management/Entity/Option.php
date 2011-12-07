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
}
