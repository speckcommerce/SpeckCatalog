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
        return $this->persist($this->getModel($constructor), 'insert');
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
        
        $model = $this->fromArray($row->getArrayCopy());
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
        $db = $this->getWriteAdapter();
        return $db->delete($table, 'linker_id = ' . $linkerId);
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
        $select = new Select();
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
        $vars = get_object_vars($model);
        foreach($vars as $key => $val){
            unset($vars[$key]);
            $key = $this->fromCamelCase($key);
            if(in_array($key, $this->getTableFields())){
                $array[$key] = $val;
            }
        }
        return $array;
    }

    public function fromArray($array)
    {
        $model = $this->getModel();
        foreach($array as $key => $val){
            $setterMethod = 'set' . $this->toCamelCase($key);
            if(method_exists($model,$setterMethod)){
                $model->$setterMethod($val);
            }
        }
        return $model;   
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
        return $this->toArray($model);
        //$data['search_data'] = $model->getSearchData();
        $this->events()->trigger(__FUNCTION__, $this, array('data' => $data));
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
        $row = $this->prepareRow($model);

        $table = $this->getTable(); 
        if ('update' === $mode) {
            $table->update( $data, array($this->getIdField => $model->getId()));
        } elseif ('insert' === $mode) {
            $result = $table->insert($data);
            if($result === 0){
                var_dump("could not insert:", var_dump($data), "into table:", $this->getTableName());
                throw new Exception('query returned no result - insert failed');
            }
            $model->setId($table->getLastInsertId());
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
