<?php

namespace Catalog\Model;

abstract class ModelAbstract implements ModelInterface
{
    /**
     * revUserId
     *
     * @var int
     * @access protected
     */
    protected $revUserId;

    /**
     * revDateTime
     *
     * @var string
     * @access protected
     */
    protected $revDateTime;

    /**
     * recordId
     *
     * @var int
     * @access protected
     */
    protected $recordId;

    public function has($prop)
    {
        $getter = 'get' . ucfirst($prop);
        if(is_callable($this, $getter) && is_array($this->$getter())){
            return true;
        }
    }

    public function getRevUserId()
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
        if(is_numeric($recordId)){
            $recordId = (int) $recordId;
        }
        $this->recordId = $recordId;
        return $this;
    }
}
