<?php
namespace SpeckCatalog\Model;

use ZfcBase\Model\ModelAbstract;

class SearchData extends ModelAbstract
{
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
