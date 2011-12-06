<?php

namespace Management\Entity;

class Option extends \Catalog\Entity\Option
{
    protected $shellId;
    protected $selectedChoiceId;
    protected $choiceIds;
 
    public function getShellId()
    {
        return $this->shellId;
    }
 
    public function setShellId($shellId)
    {
        $this->shellId = $shellId;
        return $this;
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
}
