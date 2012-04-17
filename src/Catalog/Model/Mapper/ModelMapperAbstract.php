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
     * Fetches all records in a table, does not get child models/etc.
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

    public function updateSort($table, $order, $idField = null)
    {
        $db = $this->getWriteAdapter();
        $weight = count($order);
        $return = '';
        foreach($order as $linkerId){
            $row = array(
                'sort_weight' => $weight,
            );
            if (null === $idField){
                $idField = 'linker_id';
            }
            $sql = "update {$table} set sort_weight = {$weight} where {$idField} = {$linkerId};";
            $return .= $sql . "\n";
            $db->query($sql);
            //$result = $db->update($table, $row, $db->quoteInto('linker_id = ?', $linkerId));
            $weight--;
        }
        return $return;
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
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where($this->getIdField() . ' = ?', $id);
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
            //var_dump($this->getTableName());
            //var_dump($db->quoteInto($field, $model->getId()));
            //var_dump( (array) $data);
            $db->update($this->getTableName(), (array) $data, $db->quoteInto($field, $model->getId()));
        } elseif ('insert' === $mode) {
            $result = $db->insert($this->getTableName(), (array) $data);
            if($result === 0){
                echo "could not insert:";    
                var_dump($data);
                echo "into table:";
                var_dump($this->getTableName());
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
