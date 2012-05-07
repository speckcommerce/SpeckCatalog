<?php

namespace Catalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract,
    Zend\Db\Sql\Select,
    Zend\Db\Sql\Where,
    Zend\Db\Sql\Update,
    Zend\Db\Sql\Insert,
    ArrayObject,
    Exception;

/**
 * DbMapperAbstract 
 * 
 * @uses ZfcDbMapperAbstract
 */
abstract class ModelMapperAbstract extends DbMapperAbstract implements ModelMapperInterface
{
    protected $sqlFactory;
    protected $tableFields;
    
    public function getTable()
    {
        return $this->getTableGateway();
    }

    public function getTableName()
    {
        return $this->getTable()->getTableName();
    }

    public function newSelect()
    {
        return new Select();
    }

    public function getTableFields()
    {
        if(!$this->tableFields){
            $adapter = $this->getTable()->getAdapter();
            $sql = 'describe ' . $this->getTableName();
            $result = $adapter->query($sql)->execute();
            $fields = array();
            foreach($result as $col){
                $fields[] = $col['Field'];
            }
            $this->tableFields = $fields;
        }
        return $this->tableFields;
    }

    /**
     * rowToModel
     *
     * Instantiates a new model, and populates from an array of data.
     *
     * @param mixed $row 
     * @access public
     * @return void
     */
    public function rowToModel($row=null)
    {
        if(!$row){
            return false;
        }
        $model = $this->fromArray($row);
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $model));
        return $model;
    }

    public function rowsetToModels($rows=null)
    {
        $models = array();
        if($rows){
            foreach($rows as $row){
                $models[] = $this->rowToModel($row);
            }
        }
        return $models;
    }
    
    /**
     * getAll 
     * 
     * Fetches all records in a table, does not get child/parent models (populateModel)
     * 
     * @access public
     * @return void
     */
    public function getAll()
    {
        $select = $this->newSelect();
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->select($select);

        return $this->rowsetToModels($rowset);
    }  

    public function updateSort($table, $order, $idField = null)
    {
        $db = $this->getWriteAdapter();
        $weight = count($order);
      
        foreach($order as $linkerId){
            $row = array(
                'sort_weight' => $weight,
            );
            if (null === $idField){
                $idField = 'linker_id';
            }
            $sql = "update {$table} set sort_weight = {$weight} where {$idField} = {$linkerId};";
            $result = $db->query($sql);
            $weight--;
        }

        return $result;
    }

    public function deleteLinker($table, $linkerId)
    {
        return $this->getTable()->delete('linker_id = ' . $linkerId);
    }

    public function insertLinker($linkerTable, $row)
    {
        $select = $this->newSelect();
        
        $select->from($linkerTable->getTableName())
               ->where($row);
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $linkerTable->selectWith($select);
        if($rowset->current()){
            die('already have one!');
        }

        $linkerTable->insert($row);
        return $linkerTable->getLastInsertId(); 
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
        $result = $db->delete($this->getTableName(), $this->getIdField() . ' = ' . $id);
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
        $select = $this->newSelect();
        $select->from($this->getTable()->getTableName())
               ->where(array($this->getIdField() => $id));
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowToModel($rowset->current());   
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
        
        return $this->rowsToModels($rows); 
    }  

    public function toArray($model)
    {
        $fields = $this->getTableFields();
        $return = array();
        foreach($fields as $field){
            $getterMethod = 'get' . $this->toCamelCase($field);
            if(method_exists($model, $getterMethod)){
                $return[$field] = $model->$getterMethod();
            }
        }
        return $return;
    }

    public function fromArray($array)
    {
        $model = $this->getModel();
        foreach($array as $key => $val){
            $setterMethod = 'set' . $this->toCamelCase($key);
            if(method_exists($model, $setterMethod)){
                $model->$setterMethod($val);
            }
        }
        return $model;   
    }           

    public function add($model)
    {
        return $this->persist($model);
    }

    public function update($model)
    {
        return $this->persist($model, 'update');
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
        $row = $this->toArray($model);

        $table = $this->getTable(); 
        if ('update' === $mode) {
            $result = $table->update($row, array($this->getIdField() => $model->getId()));
        } elseif ('insert' === $mode) {
            $result = $table->insert($row);
            $model->setId($table->getLastInsertId());
        }
        if($result === 0){
            var_dump("didn't execute properly:",$this->getTableName(), $mode, $row);
            throw new Exception('query returned no result - insert failed');
        }
        return $model;
    }

    public static function toCamelCase($name)
    {
        return implode('',array_map('ucfirst', explode('_',$name)));
    }

    public static function fromCamelCase($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '_'.strtolower($c[1]); }, $name),'_');
    }      

    //todo:: get the ui field from the tablegateway.
    public function getIdField()
    {
        $class = explode('\\', get_class($this->getModel()));
        $className = array_pop($class);
        return $this->fromCamelCase($className) . '_id';
    }

}
