<?php
namespace SpeckCatalog\Model;
use ZfcBase\Model\ModelAbstract as ZfcModelAbstract;

abstract class ModelAbstract extends ZfcModelAbstract
{
    
    protected $userId;
    protected $datetime;
    protected $parentId;
    protected $id;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
 
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
 
    public function getDatetime()
    {
        return $this->datetime;
    }
 
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
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

}
