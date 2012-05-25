<?php

namespace Catalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract,
    Zend\Db\Sql\Select,
    Zend\Db\Sql\Where,
    Zend\Db\Sql\Update,
    Zend\Db\Sql\Insert,
    ArrayObject,
    Exception;

abstract class ModelMapperAbstract extends DbMapperAbstract implements ModelMapperInterface
{
    protected $userId = 99;
    protected $timer=false;
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

    public function selectOne($select)
    {
        $this->userId=99;
        $revSelect = $this->revSelect($select);
        $row = $this->getTable()->getAdapter()->query($revSelect)->execute()->current();
        if($row){
            return $this->rowToModel($row);   
        }
    }

    public function selectMany($select)
    {
        $this->userId=99;
        $revSelect = $this->revSelect($select);
        $rowset = $this->getTable()->getAdapter()->query($revSelect)->execute();

        return $this->rowsetToModels($rowset);  
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
        return $this->selectMany($select);   
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
        $id = (int) $linkerTable->getLastInsertValue();
        $linkerTable->getAdapter()->query("update {$linkerTable->getTableName()} set linker_id = {$id} where rev_id = {$id}")->execute();
        return $id; 
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
        if($id === 0){
            return false;
        }
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->where(array('record_id' => $id));
        return $this->selectOne($select);
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
            if(is_callable(array($model, $getterMethod))){
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

    public function revSelect($select, $startDateTime=null, $endDateTime=null)
    {
        $sqlBuilder = new RevisionQueryBuilder($this->getTableName(), $this->getTableFields(), $select, $this->userId);
        return $sqlBuilder->build();
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
    public function persist($model, $mode = 'insert', $revId=null)
    {
        $row = $this->toArray($model);
        if ($revId) $row['rev_id'] = $revId; //hack to import existing records
        $row['rev_user_id'] = $this->userId;
        $row['rev_datetime'] = 1;
        $table = $this->getTable();
        if ('update' === $mode) {
            $connection = $table->getAdapter()->getDriver()->getConnection();
            try{
                $connection->beginTransaction(); 
                $table->update(array('rev_active' => 0, 'rev_eol_datetime' => 1), array('record_id' => $model->getRecordId()));
                $table->insert($row);
                $connection->commit();
            }catch (Exception $e){
                $connection->rollback();
                throw new \Exception($e);
            }
        } elseif ('insert' === $mode) {
            $table->insert($row);
            $id = (int) $table->getLastInsertValue();
            $table->getAdapter()->query("update {$table->getTableName()} set record_id = {$id} where rev_id = {$id}")->execute();
            $model->setRecordId($id);
        }
        return $model;
    }      

    public static function toCamelCase($name)
    {
        return implode('', array_map('ucfirst', explode('_',$name)));
    }

    public static function fromCamelCase($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '_'.strtolower($c[1]); }, $name),'_');
    }      
}
