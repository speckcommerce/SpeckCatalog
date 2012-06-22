<?php

namespace Catalog\Model;

abstract class LinkedModelAbstract extends ModelAbstract
{
    /**
     * linkerId 
     * 
     * @var int
     * @access protected
     */
    protected $linkerId;

    /**
     * sortWeight 
     * 
     * @var int
     * @access protected
     */
    protected $sortWeight;
 
    public function getLinkerId()
    {
        return $this->linkerId;
    }
 
    public function setLinkerId($linkerId)
    {
        $this->linkerId = $linkerId;
        return $this;
    }
 
    public function getSortWeight()
    {
        return $this->sortWeight;
    }
 
    public function setSortWeight($sortWeight)
    {
        $this->sortWeight = $sortWeight;
        return $this;
    }
}
