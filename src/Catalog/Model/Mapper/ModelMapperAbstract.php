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
        $id = (int)$linkerTable->getLastInsertId();
        $row['linker_id'] = $id;
        $row['rev_id'] = $id;
        $linkerTable->update($row, array('rev_id' => $id));
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
        $select->from($this->getTable()->getTableName())
            ->where(array('record_id' => $id));
        $select = $this->newRevSelect($select);
        $row = $this->getTable()->selectWith($select)->current();
        if($row){
            return $this->rowToModel($row);  
        }else{
            var_dump(get_class($this->getModel()));
            throw new \Exception('couldnt get that one');
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

    public function fieldsToString()
    {
        $tableFields = $this->getTableFields();
        $fieldString = '';
        foreach($tableFields as $i => $field){
            if($field==='rev_active'){
            }else{
                $fieldString .= "{$this->getTableName()}.{$field}, \n ";
            }
        }
        return substr($fieldString,0,-4);  
    }    

    public function newRevSelect($select, $startDateTime=null, $endDateTime=null)
    {
        $tableName = $this->getTableName();
        $whereString = "catalog_product.record_id = 205";
        $linkerName = 'catalog_choice';
        $joinLinker = $this->joinLinker($tableName, $linkerName);

$select = "
SELECT 
 {$this->fieldsToString()}
FROM(
    SELECT max( rev_id ) AS max_rev_id, rev_user_id AS {$tableName}_rev_user_id, rev_eol_datetime as {$tableName}_eol_datetime
    FROM {$tableName} as t1
    WHERE (rev_user_id = {$this->userId} OR (rev_user_id IS NULL AND rev_eol_datetime IS NULL))
    GROUP BY record_id, {$tableName}_rev_user_id
) as t2
JOIN {$tableName} ON t2.max_rev_id = {$tableName}.rev_id
"
{$joinLinker}
WHERE({$whereString})
";
die($select.$joinLinker.$wheres);
    }
    
    public function joinLinker($tableName, $linkerName)
    {
$sql = "
    SELECT * FROM(
        SELECT max( rev_id ) AS max_rev_id, rev_user_id AS {$linkerName}_rev_user_id, rev_eol_datetime as {$linkerName}_eol_datetime,
        record_id as {$linkerName}_record_id2
        FROM {$linkerName} as l1
        WHERE (rev_user_id = {$this->userId} OR (rev_user_id IS NULL AND rev_eol_datetime IS NULL))
        GROUP BY {$linkerName}_record_id2, {$linkerName}_rev_user_id
    ) as l2
    JOIN {$linkerName} ON l2.max_rev_id = {$linkerName}.rev_id
";  
        return "JOIN ({$sql}) as linker ON {$tableName}.record_id = linker.product_id";
    }

    public function revSelect($select, $startDateTime=null, $endDateTime=null)
    {
        $raw = $select->where();
        var_dump($raw);die();
        $tables = array($raw['table']); 
        foreach ($raw['joins'] as $join){ $tables[] = $join['name']; }
        foreach ($tables as $table){
            $select->where(array("{$table}.rev_active" => 1));
        }
        if(isset($this->userId)){
            //$select->where(array('rev_user_id' => $this->userId));
        }
        return $select;
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
        $row['rev_user_id'] = $this->userId;
        $table = $this->getTable();
        if ('update' === $mode) {
            $connection = $table->getAdapter()->getDriver()->getConnection();
            try{
                $connection->beginTransaction(); 
                $table->update(array('rev_active' => 0), array('record_id' => $model->getRecordId()));
                $table->insert($row);
                $connection->commit();
            }catch (Exception $e){
                $connection->rollback();
                throw new \Exception($e);

            }
        } elseif ('insert' === $mode) {
            $table->insert($row);
            $id = (int)$table->getLastInsertId();
            $row['record_id'] = $id;
            $row['rev_id'] = $id;
            $table->update($row, array('rev_id' => $id));
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
