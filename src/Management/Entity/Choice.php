<?php

namespace Management\Entity;

class Choice extends \Catalog\Entity\Choice
{
    protected $shellId;
    protected $targetUomId;
    protected $parentOptionIds;

    public function getShellId()
    {
        return $this->shellId;
    }

    public function setShellId($shellId)
    {
        $this->shellId = $shellId;
        return $this;
    }

    public function getTargetUomId()
    {
        return $this->targetUomId;
    }
 
    public function setTargetUomId($targetUomId)
    {
        $this->targetUomId = $targetUomId;
        return $this;
    }
 
    public function getParentOptionIds()
    {
        return $this->parentOptionIds;
    }
 
    public function setParentOptionIds($parentOptionIds)
    {
        $this->parentOptionIds = $parentOptionIds;
        return $this;
    }

    public function deflate()
    {
        $shell = $this->getShell();
        if($shell){
            $this->setShellId($shell->getShellId());
        }
        $this->setShell(null);
        
        $productUom = $this->getTargetUom();
        if($productUom){
            $this->setTargetUomId($productUom->getProductUomId());
        }
        $this->setTargetUom(null);

        $parentOptionIds = array();
        if(count($this->getParentOptions()) > 0){
            foreach($this->getParentOptions() as $option){
                $parentOptionIds[] = $option->getOptionId();
            }
        }
        $this->setParentOptionIds($parentOptionIds);
        $this->setParentOptions(null);
        
    }  
}
