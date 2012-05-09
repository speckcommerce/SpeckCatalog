<?php
namespace Catalog\Model;
use ZfcBase\Model\ModelAbstract as ZfcModelAbstract,
    Traversable,
    Zend\EventManager\EventManager,
    Zend\EventManager\EventCollection;

abstract class ModelAbstract implements ModelInterface
{
    protected $isPopulated = false;
    protected $revUserId;
    protected $revDateTime;
    protected $recordId;
    protected $searchData;

    public function getSearchData()
    {
        return $this->searchData;
    }

    public function isPopulated($flag=null)
    {
        if($flag){
            $this->isPopulated = true;
        }
        return $this->isPopulated;
    }     public function getRevUserId()

    {
        return $this->revUserId;
    }
 
    public function setRevUserId($revUserId)
    {
        $this->revUserId = $revUserId;
        return $this;
    }

    public function getRevDateTime()
    {
        return $this->revDateTime;
    }

    public function setRevDateTime($revDateTime)
    {
        $this->revDateTime = $revDateTime;
        return $this;
    }

    public function getRevParentId()
    {
        return $this->revParentId;
    }

    public function setRevParentId($revParentId)
    {
        $this->revParentId = $revParentId;
        return $this;
    }

    public function getRecordId()
    {
        return $this->recordId;
    }

    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
        return $this;
    }
}
