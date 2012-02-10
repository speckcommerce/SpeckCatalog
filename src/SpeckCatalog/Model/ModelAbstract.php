<?php
namespace SpeckCatalog\Model;
use ZfcBase\Model\ModelAbstract as ZfcModelAbstract,
    Traversable,
    Zend\EventManager\EventManager,
    Zend\EventManager\EventCollection;

abstract class ModelAbstract extends ZfcModelAbstract
{
    
    protected $revUserId;
    protected $revDateTime;
    protected $revParentId;
    protected $revId;



    private function arrToData($arr, $searchData){
        foreach($arr as $val){
            if(is_array($val)){
                $searchData = $this->arrToData($val, $searchData);
            }else{
                if(strstr($val, ' ')){
                    $searchData = $this->arrToData(explode(' ', $val),$searchData);
                }else{
                    if(strlen($val) > 1) $searchData[$val] = strtolower($val);
                }   
            }   
        }
        return $searchData;
    }

    public function getSearchData(){
        $arr = $this->arrToData($this->toArray(), array());
        return implode(' ', $arr);
    }   


    /**
     * @var EventCollection
     */
    protected $events;

    /**
     * Set the event manager instance used by this context
     * 
     * @param  EventCollection $events 
     * @return mixed
     */
    public function setEventManager(EventCollection $events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     * 
     * @return EventCollection
     */
    public function events()
    {
        if (!$this->events instanceof EventCollection) {
            $identifiers = array(__CLASS__, get_class($this));
            if (isset($this->eventIdentifier)) {
                if ((is_string($this->eventIdentifier))
                    || (is_array($this->eventIdentifier))
                    || ($this->eventIdentifier instanceof Traversable)
                ) {
                    $identifiers = array_unique(array_merge($identifiers, (array) $this->eventIdentifier));
                } elseif (is_object($this->eventIdentifier)) {
                    $identifiers[] = $this->eventIdentifier;
                }
                // silently ignore invalid eventIdentifier types
            }
            $this->setEventManager(new EventManager($identifiers));
        }
        return $this->events;
    }

    public function __toArray($model){
        $array = parent::__toArray($model);
        foreach($array as $key => $val){
            if(is_array($val)){
                unset($array[$key]);
            }
        }
        return array();
    }

 
    /**
     * Get revUserId.
     *
     * @return revUserId
     */
    public function getRevUserId()
    {
        return $this->revUserId;
    }
 
    /**
     * Set revUserId.
     *
     * @param $revUserId the value to be set
     */
    public function setRevUserId($revUserId)
    {
        $this->revUserId = $revUserId;
        return $this;
    }
 
    /**
     * Get revDateTime.
     *
     * @return revDateTime
     */
    public function getRevDateTime()
    {
        return $this->revDateTime;
    }
 
    /**
     * Set revDateTime.
     *
     * @param $revDateTime the value to be set
     */
    public function setRevDateTime($revDateTime)
    {
        $this->revDateTime = $revDateTime;
        return $this;
    }
 
    /**
     * Get revParentId.
     *
     * @return revParentId
     */
    public function getRevParentId()
    {
        return $this->revParentId;
    }
 
    /**
     * Set revParentId.
     *
     * @param $revParentId the value to be set
     */
    public function setRevParentId($revParentId)
    {
        $this->revParentId = $revParentId;
        return $this;
    }
 
    /**
     * Get revId.
     *
     * @return revId
     */
    public function getRevId()
    {
        return $this->revId;
    }
 
    /**
     * Set revId.
     *
     * @param $revId the value to be set
     */
    public function setRevId($revId)
    {
        $this->revId = $revId;
        return $this;
    }
}
