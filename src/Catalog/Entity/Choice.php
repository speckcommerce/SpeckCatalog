<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping AS ORM;
    

/**
 * @ORM\Entity
 * @ORM\Table(name="option_choice")
 */
class Choice
{
    /**
     * @ORM\Id
     * @ORM\Column(name="option_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */             
    private $choiceId;

    protected $name;

    //this is the child shell.
    protected $shell;

    protected $targetUom;

    protected $targetUomDiscount;

    protected $allUomsDiscount;

    public function getName()
    {
        return $this->name;
    }
 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
 
    public function getShell()
    {
        return $this->shell;
    }
 
    public function setShell(Shell $shell)
    {
        $this->shell = $shell;
        return $this;
    }

    public function getTargetUom()
    {
        return $this->targetUom;
    }
 
    public function setTargetUom(ProductUom $targetUom)
    {
        $this->targetUom = $targetUom;
        return $this;
    }
 
    public function getTargetUomDiscount()
    {
        return $this->targetUomDiscount;
    }
 
    public function setTargetUomDiscount($targetUomDiscount)
    {
        $this->targetUomDiscount = $targetUomDiscount;
        return $this;
    }
 
    public function getAllUomsDiscount()
    {
        return $this->allUomsDiscount;
    }
 
    public function setAllUomsDiscount($allUomsDiscount)
    {
        $this->allUomsDiscount = $allUomsDiscount;
        return $this;
    }
 
    public function getChoiceId()
    {
        return $this->choiceId;
    }
 
    public function setChoiceId($choiceId)
    {
        $this->choiceId = $choiceId;
        return $this;
    }
}
