<?php
namespace Catalog\Model;
use ZfcBase\Model\ModelAbstract as ZfcModelAbstract,
    Traversable,
    Zend\EventManager\EventManager,
    Zend\EventManager\EventCollection;

abstract class ModelAbstract implements ModelInterface
{
    private $isPopulated = false; //must remain private
    protected $revUserId;
    protected $revDateTime;
    protected $revParentId;
    protected $revId;

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

    public function toArray()
    {
        $vars = get_object_vars($this);
        foreach($vars as $key => $val){
            unset($vars[$key]);
            if(is_scalar($val)){
                $key = $this->fromCamelCase($key);
                $array[$key] = $val;
            }
        }
        return $array;
    }

    public function fromArray($array)
    {
        foreach($array as $key => $val){
            $setterMethod = 'set' . $this->toCamelCase($key);
            if(method_exists($this,$setterMethod)){
                $this->$setterMethod($val);
            }
        }
        return $this;   
    }    


    public static function toCamelCase($name)
    {
        return implode('',array_map('ucfirst', explode('_',$name)));
    }

    public static function fromCamelCase($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '_'.strtolower($c[1]); }, $name),'_');
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

    public function getRevId()
    {
        return $this->revId;
    }

    public function setRevId($revId)
    {
        $this->revId = $revId;
        return $this;
    }

}
