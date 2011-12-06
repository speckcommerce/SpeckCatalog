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
    protected $shellId;

    protected $targetUom;
    protected $targetUomId;

    protected $targetUomDiscount;

    protected $allUomsDiscount;

    /**
     * Get name.
     *
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }
 
    /**
     * Set name.
     *
     * @param $name the value to be set
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
 
    /**
     * Get shell.
     *
     * @return shell
     */
    public function getShell()
    {
        return $this->shell;
    }
 
    /**
     * Set shell.
     *
     * @param $shell the value to be set
     */
    public function setShell(Shell $shell)
    {
        $this->shell = $shell;
        return $this;
    }
 
    /**
     * Get targetUom.
     *
     * @return targetUom
     */
    public function getTargetUom()
    {
        return $this->targetUom;
    }
 
    /**
     * Set targetUom.
     *
     * @param $targetUom the value to be set
     */
    public function setTargetUom(ProductUom $targetUom)
    {
        $this->targetUom = $targetUom;
        return $this;
    }
 
    /**
     * Get targetUomDiscount.
     *
     * @return targetUomDiscount
     */
    public function getTargetUomDiscount()
    {
        return $this->targetUomDiscount;
    }
 
    /**
     * Set targetUomDiscount.
     *
     * @param $targetUomDiscount the value to be set
     */
    public function setTargetUomDiscount($targetUomDiscount)
    {
        $this->targetUomDiscount = $targetUomDiscount;
        return $this;
    }
 
    /**
     * Get allUomsDiscount.
     *
     * @return allUomsDiscount
     */
    public function getAllUomsDiscount()
    {
        return $this->allUomsDiscount;
    }
 
    /**
     * Set allUomsDiscount.
     *
     * @param $allUomsDiscount the value to be set
     */
    public function setAllUomsDiscount($allUomsDiscount)
    {
        $this->allUomsDiscount = $allUomsDiscount;
        return $this;
    }
 
    /**
     * Get choiceId.
     *
     * @return choiceId
     */
    public function getChoiceId()
    {
        return $this->choiceId;
    }
 
    /**
     * Set choiceId.
     *
     * @param $choiceId the value to be set
     */
    public function setChoiceId($choiceId)
    {
        $this->choiceId = $choiceId;
        return $this;
    }
 
    /**
     * Get shellId.
     *
     * @return shellId
     */
    public function getShellId()
    {
        return $this->shellId;
    }
 
    /**
     * Set shellId.
     *
     * @param $shellId the value to be set
     */
    public function setShellId($shellId)
    {
        $this->shellId = $shellId;
        return $this;
    }
 
    /**
     * Get targetUomId.
     *
     * @return targetUomId
     */
    public function getTargetUomId()
    {
        return $this->targetUomId;
    }
 
    /**
     * Set targetUomId.
     *
     * @param $targetUomId the value to be set
     */
    public function setTargetUomId($targetUomId)
    {
        $this->targetUomId = $targetUomId;
        return $this;
    }
}
