<?php

namespace SpeckCatalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract as ZfcDbMapperAbstract,
    ArrayObject;
class DbMapperAbstract extends ZfcDbMapperAbstract
{
    protected $modelClass;

    public function newModel($constructor=null)
    {
        $fullClassName = $this->getFullClassName();
        $model = new $fullClassName($constructor);
        return $this->add($model);
    }    
    
    public function getAll()
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName());
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

    public function deleteById($id)
    {
        $db = $this->getReadAdapter();
        $result = $db->delete(
            $this->getTableName(),
            $this->fromCamelCase($this->getModelClass()).'_id = '.$id
        );
        die($result);
    }

    public function getModelById($id)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where($this->fromCamelCase($this->getModelClass()).'_id = ?', $id);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        return $this->instantiateModel($row);
    }     

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
    public function add($model)
    {
        return $this->persist($model);
    }

    public function update($model)
    {
        die($model);
        return $this->persist($model, 'update');
    }    
    
    public function persist($model, $mode = 'insert')
    {
        $data = new ArrayObject(
            $model->toArray(
                NULL,
                function($v){
                    return htmlentities($v);
                }
            )
        );
        
        $data['search_data'] = $model->getSearchData();
        
        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('data' => $data));
        $db = $this->getWriteAdapter();
        
        if ('update' === $mode) {
            
            $getModelId = 'get'.ucfirst($this->getModelClass()).'Id';
            $db->update(
                $this->getTableName(), 
                (array) $data, 
                $db->quoteInto($this->fromCamelCase($this->getModelClass()).'_id = ?', $model->$getModelId())
            );
            $model = $this->getModelById($model->$getModelId()); 

        } elseif ('insert' === $mode) {

            $db->insert($this->getTableName(), (array) $data);
            $setModelId = 'set'.ucfirst($this->getModelClass()).'Id';
            $model->$setModelId($db->lastInsertId());

        }

        return $model;
    }
    public function getFullClassName()
    {
        return '\SpeckCatalog\Model\\'.$this->getModelClass();  
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }
 
    public function setModelClass($modelClass)
    {
        $this->modelClass = $modelClass;
        return $this;
    }

    public static function fromCamelCase($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '_'.strtolower($c[1]); }, $name),'_');
    }     
}
