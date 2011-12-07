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
}
