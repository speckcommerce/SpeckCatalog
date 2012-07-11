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
        if(method_exists($this, $getter)){
            if('s' === substr($prop, 0, -1) && is_array($this->$getter())){
                return true;
            }elseif($this->$getter()){
                return true;
            }
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

    public function get($switch)
    {
        switch($switch){
        case 'class_name':
            return join('', array_slice(explode('\\', get_class($this)), -1));
        case 'dashed_class_name':
            $dasher = function($m){ return '-'.strtolower($m[1]); };
            return preg_replace_callback('/([A-Z])/', $dasher, lcfirst($this->get('class_name')));
        }
    }
}
