<?php

namespace SpeckCatalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract as ZfcDbMapperAbstract;
class DbMapperAbstract extends ZfcDbMapperAbstract
{
    public function getModelsBySearchData($string)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName());
        if(strstr($string, ' ')){
            $string = explode(' ', $string);
            foreach($string as $word){
                $sql->where( 'search_data LIKE ?', '%'.$word.'%');
            }
        } else {
            $sql->where( 'search_data LIKE ?', '%'.$string.'%');
        }

        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
  
        $rows = $db->fetchAll($sql);
        if($rows){
            $return = array();
            foreach($rows as $row){
                $return[] = $this->instantiateModel($row);   
            }
            return $return;
        }
    }  
}
