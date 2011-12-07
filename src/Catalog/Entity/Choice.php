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

    protected $parentOptions = array();

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
        $this->targetUom = null; //keep this, if the shell changes, the targetuom must be reset. 
        $this->shell = $shell;
        return $this;
    }

    public function getTargetUom()
    {
        return $this->targetUom;
    }
    
    public function setTargetUom(ProductUom $targetUom)
    {
        $shell = $this->getShell();
        if($shell->getType() !== 'product'){
            throw new \RuntimeException('shell is not product, can not have target uom!');
        }
        $productUomIds=array();
        foreach($shell->getProduct()->getUoms() as $productUom){
            $productUomIds[] = $productUom->getProductUomId();
        }
        if(!in_array($targetUom->getProductUomId(), $productUomIds)){
            throw new \RuntimeException('shells product does not contain that productUom!');
        }
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
