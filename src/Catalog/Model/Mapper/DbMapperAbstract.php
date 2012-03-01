<?php

namespace Catalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract as ZfcDbMapperAbstract,
    ArrayObject,
    Exception;

/**
 * DbMapperAbstract 
 * 
 * @uses ZfcDbMapperAbstract
 */
abstract class DbMapperAbstract extends ZfcDbMapperAbstract
{

    /**
     * newModel
     *
     * Instantiates a new model + record.
     * 
     * @param mixed $constructor 
     * @access public
     * @return void
     */
    public function newModel($constructor=null)
    {
        return $this->add($this->getModel($constructor));
    }


    /**
     * mapModel
     *
     * Instantiates a new model, and populates from an array of data.
     *
     * @param mixed $row 
     * @access public
     * @return void
     */
    public function mapModel($row)
    {
        $model = $this->getModel();
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $model));
        return $model->fromArray($row);
    }


    /**
     * getAll 
     * 
     * Fetches all records in a table
     * 
     * @access public
     * @return void
     */
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
                $return[] = $this->mapModel($row);   
            }
            return $return;
        }
    }  


    /**
     * deleteById 
     *
     * Deletes a row, this will soon be replaced with an insert/update to make it 'appear' deleted
     * 
     * @param mixed $id 
     * @access public
     * @return void
     */
    public function deleteById($id)
    {
        $db = $this->getWriteAdapter();
        $result = $db->delete(
            $this->getTableName(),
            $this->fromCamelCase($this->getModelClass()).'_id = '.$id
        );
        die($result);
    }


    /**
     * getById 
     *
     * Get a single row by the primary key
     * 
     * @param mixed $id 
     * @access public
     * @return void
     */
    public function getById($id)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where($this->fromCamelCase($this->getModelClass()).'_id = ?', $id);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if($row){
            return $this->mapModel($row);
        } 
    }     

    
    /**
     * getModelsBySearchData 
     * 
     * All catalog tables have a search_data field, this is used for quick 
     * searching of records to link.
     *
     * @param mixed $string 
     * @access public
     * @return void
     */
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
                $return[] = $this->mapModel($row);   
            }
            return $return;
        }
    }  


    /**
     * add 
     *
     * adds a new record in the database
     * 
     * @param mixed $model 
     * @access public
     * @return void
     */
    public function add($model)
    {
        return $this->persist($model);
    }


    /**
     * update 
     * 
     * updates an existing record in the database
     *
     * @param mixed $model 
     * @access public
     * @return void
     */
    public function update($model)
    {
        return $this->persist($model, 'update');
    }    

    
    /**
     * prepareRow
     *
     * takes a model and returns a flat array object, to be used for insert/updates  
     * 
     * @param mixed $model 
     * @access public
     * @return void
     */
    protected function prepareRow($model)
    {
        $data = $model->toArray(NULL, function($v){ return htmlentities($v); });
        $data['search_data'] = $model->getSearchData();
        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('data' => $data));

        return new ArrayObject($data);
    }
    
    
    /**
     * persist 
     * 
     * this handles the writing to the database
     *
     * @param mixed $model 
     * @param string $mode 
     * @access public
     * @return void
     */
    public function persist($model, $mode = 'insert')
    {
        $data = $this->prepareRow($model); 
        $db = $this->getWriteAdapter();
        if ('update' === $mode) {
            $field = $this->fromCamelCase($this->getModelclass()) . '_id = ?';
            $db->update($this->getTableName(), (array) $data, $db->quoteInto($field, $model->getId()));
        } elseif ('insert' === $mode) {
            $result = $db->insert($this->getTableName(), (array) $data);
            if($result === 0){
                echo "could not insert:";    
                var_dump($data);
                echo "into table:";
                var_dump($this->getTableName());
                //die();
            }

            $setModelId = 'set' . ucfirst($this->getModelClass()) . 'Id';
            $model->$setModelId($db->lastInsertId());
        }
        return $model;
    }

    /**
     * fromCamelCase
     *
     * takes a camelCase model property name and returns a underscore_separated database column name
     * 
     * @param mixed $name 
     * @static
     * @access public
     * @return void
     */
    public static function fromCamelCase($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '_'.strtolower($c[1]); }, $name),'_');
    }     

    public function getModelClass()
    {
        $class = explode('\\', get_class($this->getModel())); 
        return array_pop($class);
    } 


}
