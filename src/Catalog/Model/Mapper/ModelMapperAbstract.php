<?php

namespace Catalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract,
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
    protected $table;
    
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
    public function mapModel($row)
    {
        echo "something still using mapmodel function";
        return $this->rowToModel($row);
    }
    public function rowToModel($row)
    {
        $model = $this->getModel();
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $model));
        return $model->fromArray($row);
    }
    public function rowsToModels($rows=null)
    {
        $models = array();
        if(is_array($rows)){
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
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName());
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));   
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
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
        $table = $this->getTable();
        //$db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where($this->getIdField() . ' = ?', $id);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if($row){
            return $this->rowToModel($row);
        } 
    }

    public function new_getById($id)
    {
        $where = $this->newSql('where')->equalTo($this->getIdField(), $id);
        $select = $this->newSql('select')->where($where);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $select));

        return $this->rowToModel($this->getTable()->select($select));
    }

    public function newSql($type=null)
    {
        return $this->getSqlFactory($type);
    }

    public function getSqlFactory($type=null)
    {
        return $this->sqlFactory($type);
    }

    public function setSqlFactory($sqlFactory)
    {
        $this->sqlFactory = $sqlFactory;
        return $this;
    }

    public function getTable()
    {
        if($this->table){
            return clone $this->table;
        }
        $this->table = new TableGateway($this->getTableName(), 'adaptergoeshere');
        return clone $this->table;
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
        $this->events()->trigger(__FUNCTION__, $this, array('data' => $data));

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
            $field = $this->getIdField() . ' = ?';
            $db->update($this->getTableName(), (array) $data, $db->quoteInto($field, $model->getId()));
        } elseif ('insert' === $mode) {
            $result = $db->insert($this->getTableName(), (array) $data);
            if($result === 0){
                var_dump("could not insert:", var_dump($data), "into table:", $this->getTableName());
                throw new Exception('query returned no result - insert failed');
            }
            $model->setId($db->lastInsertId());
        }
        return $model;
    }

    public function fromCamelCase($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '_'.strtolower($c[1]); }, $name),'_');
    }     

    public function getIdField()
    {
        $class = explode('\\', get_class($this->getModel()));
        $className = array_pop($class);
        return $this->fromCamelCase($className) . '_id';
    }

}
