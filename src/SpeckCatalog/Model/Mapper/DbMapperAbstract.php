<?php

namespace SpeckCatalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract as ZfcDbMapperAbstract,
    ArrayObject,
    Exception;
class DbMapperAbstract extends ZfcDbMapperAbstract
{
    protected $modelClass;
    protected $debugging;

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

    public function getById($id)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where($this->fromCamelCase($this->getModelClass()).'_id = ?', $id);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if($row){
            return $this->instantiateModel($row);
        }elseif($this->debugging){
            echo get_class($this)."::getById({$id}) returned no row";
        }
        
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
        return $this->persist($model, 'update');
    }    
    
    public function persist($model, $mode = 'insert')
    {

        $data = new ArrayObject($model->toArray(NULL, function($v){return htmlentities($v);}));
        $data['search_data'] = $model->getSearchData();
        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('data' => $data));
        
        $db = $this->getWriteAdapter();
        
        if ('update' === $mode) {
            $getModelId = 'get' . ucfirst($this->getModelClass()) . 'Id';
            $field = $this->fromCamelCase($this->getModelclass()) . '_id = ?';
            $db->update($this->getTableName(), (array) $data, $db->quoteInto($field, $model->$getModelId()));
        } elseif ('insert' === $mode) {
            $result = $db->insert($this->getTableName(), (array) $data);
            if($result === 0){
                echo "could not insert:";    
                var_dump($data);
                echo "into table:";
                var_dump($this->getTableName());
                //die();
            }

            $setModelId = 'set' . ucfirst($this->getModelClass()).'Id';
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
        if($this->modelClass){
            return $this->modelClass;
        } else {
            throw new Exception('modelClass not set');
        }
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
