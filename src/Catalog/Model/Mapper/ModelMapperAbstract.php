<?php

namespace Catalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract,
    Zend\Db\Sql\Select,
    Zend\ServiceManager\ServiceManagerAwareInterface,
    Zend\ServiceManager\ServiceManager,
    Catalog\Model\Mapper\TableGateway,
    ArrayObject,
    Exception;

abstract class ModelMapperAbstract
implements ModelMapperInterface, ServiceManagerAwareInterface
{
    protected $userId = 99;
    protected $tableFields;
    protected $serviceManager;
    protected $tableGateway;
    protected $hydrator;

    public function events(){return $this;}
    public function trigger(){}

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function __construct(TableGateway $tableGateway=null)
    {
        if($tableGateway){
            $this->setTableGateway($tableGateway);
        }else{
            var_dump($this);
            die('didnt get a gateway');
        }
    }

    public function getTable()
    {
        if($this->getTableGateway() instanceof TableGateway){
            return $this->getTableGateway();
        }
        var_dump($this->getTableGateway());
        die(get_class($this));
    }

    public function getTableName()
    {
        if(!$this->getTable()){
            echo 'no table gateway here - '.get_class($this); die();
        }if($this->getTable() instanceof TableGateway){
            return $this->getTable()->getTableName();
        }
        var_dump($this->getTable()); die();
    }

    public function newSelect()
    {
        return new Select();
    }

    public function getTableFields()
    {
        $adapter = $this->getTable()->getAdapter();
        $sql = 'describe ' . $this->getTableName();
        $result = $adapter->query($sql)->execute();
        $fields = array();
        foreach($result as $col){
            $fields[] = $col['Field'];
        }
        return $fields;
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
        if(null === $row){
            return false;
        }
        $model = $this->getHydrator()->hydrate($row, $this->getModel());
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

    public function insertLinker(TableGateway $linkerTable, $row)
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
        $row = $this->getHydrator()->extract($model);
        if ($revId) $row['rev_id'] = $revId; //hack to import existing records
        $row['rev_user_id'] = $this->userId;
        $row['rev_datetime'] = 1;
        $table = $this->getTable();

        if ('update' === $mode) {
            $connection = $table->getAdapter()->getDriver()->getConnection();
            var_dump($model->getRecordId());
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

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function setTableGateway($tableGateway)
    {
        $this->tableGateway = $tableGateway;
        return $this;
    }

    public function getHydrator()
    {
        if(null === $this->hydrator){
            $this->hydrator = new Hydrator($this->getTableFields());
        }
        return $this->hydrator;
    }

    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator();
        return $this;
    }
}
