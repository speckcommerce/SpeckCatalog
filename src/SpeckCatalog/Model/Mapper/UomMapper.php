<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Uom, 
    ArrayObject;

class UomMapper extends DbMapperAbstract
{
    protected $tableName = 'ansi_uom';
    protected $modelClass = 'Uom';

    //overrides abstract
    //db field does not end in _id      
    public function getById($uomCode)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('uom_code = ?', $uomCode);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if($row){
            return $this->mapModel($row);
        }elseif($this->debugging){
            echo get_class($this)."::getById({$uomCode}) returned no row";
        }
    }  

    //overrides abstract
    //where enabled = 1
    public function getAll()
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('enabled = ?', 1);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));   
     
        $rows = $db->fetchAll($sql);
        if($rows){
            $return = array();
            foreach($rows as $row){
                $return[] = $this->mapModel($row);   
            }
            return $return;
        }
    }   
}
