<?php

namespace SpeckCatalog\Mapper;

use SpeckCatalog\Model\AbstractModel;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;
use SpeckCatalog\Mapper\DbAdapterAwareInterface;
use SpeckCatalog\Adapter\PaginatorDbSelect;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet;

class AbstractMapper implements DbAdapterAwareInterface
{
    protected $hydrator;
    protected $dbAdapter;
    protected $model;
    protected $tableFields;
    protected $tableName;
    protected $tableKeyFields;
    protected $sql;
    protected $usePaginator;
    protected $paginatorOptions;

    public function getSelect($tableName = null)
    {
        return $this->getSql()->select($tableName ?: $this->getTableName());
    }

    public function getAll()
    {
        $select = $this->getSelect();
        return $this->selectManyModels($select);
    }

    public function find(array $data)
    {
        $select = $this->getSelect()
            ->where($data);
        return $this->selectOneModel($select);
    }

    //return array or null
    public function select(Select $select, ResultSet\ResultSetInterface $resultSet = null)
    {
        $stmt = $this->getSql()->prepareStatementForSqlObject($select);

        $resultSet = $resultSet ?: new ResultSet\ResultSet(ResultSet\ResultSet::TYPE_ARRAY);
        $resultSet->initialize($stmt->execute());

        return $resultSet;
    }

    //return deleted nuber of rows
    public function delete(array $where, $tableName = null)
    {
        $sql = $this->getSql($tableName ?: $this->getTableName());
        $delete = $sql->delete();

        $delete->where($where);

        $statement = $sql->prepareStatementForSqlObject($delete);

        return $statement->execute();
    }

    //returns lastInsertId or null
    public function insert($dataOrModel, $tableName = null, HydratorInterface $hydrator = null)
    {
        $tableName = $tableName ?: $this->getTableName();
        $data = $this->extract($dataOrModel, $hydrator);
        if($tableName === $this->getTableName()) {
            $data = $this->cleanData($data);
        }

        $sql = $this->getSql($tableName);
        $insert = $sql->insert();

        $insert->values($data);

        $statement = $sql->prepareStatementForSqlObject($insert);

        return $statement->execute();
    }

    //returns affected number of rows
    public function update($dataOrModel, $tableName = null, array $where, HydratorInterface $hydrator = null)
    {
        $tableName = $tableName ?: $this->getTableName();
        $data = $this->extract($dataOrModel, $hydrator);
        if($tableName === $this->getTableName()) {
            $data = $this->cleanData($data);
        }

        $sql = $this->getSql($tableName);
        $update = $sql->update();

        $update->set($data)
            ->where($where);

        $statement = $sql->prepareStatementForSqlObject($update);

        return $statement->execute();
    }

    //returns row or null
    public function selectOne(Select $select, ResultSet\ResultSetInterface $resultSet = null)
    {
        $select->limit(1);
        return $this->select($select, $resultSet)->current();
    }

    //returns array of rows
    public function selectMany(Select $select, ResultSet\ResultSetInterface $resultSet = null)
    {
        if($this->usePaginator) {
            $this->usePaginator = false;
            $rows = $this->initPaginator($select, $resultSet);
        } else {
            $result = $this->select($select, $resultSet);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    //returns model or null
    public function selectOneModel(Select $select, HydratorInterface $hydrator = null, AbstractModel $model = null)
    {
        $resultSet = new ResultSet\HydratingResultSet($this->getHydrator(), $this->getModel());
        return $this->selectOne($select, $resultSet);
    }

    //returns array of models
    public function selectManyModels(Select $select, HydratorInterface $hydrator = null, AbstractModel $model = null)
    {
        $resultSet = new ResultSet\HydratingResultSet($this->getHydrator(), $this->getModel());
        return $this->selectMany($select, $resultSet);
    }

    public function extract($dataOrModel, HydratorInterface $hydrator = null)
    {
        if (is_array($dataOrModel)) {
            return $dataOrModel;
        }
        if (!$dataOrModel instanceOf AbstractModel) {
            throw new \InvalidArgumentException('need nstance of AbstractModel got: ' . getType($dataOrModel));
        }
        $hydrator = $hydrator ?: $this->getHydrator();
        return $hydrator->extract($dataOrModel);
    }

    public function cleanData($data)
    {
        if (!is_array($this->tableFields) || !count($this->tableFields)) {
            return $data;
        }
        foreach ($data as $field) {
            if (!array_key_exists($field, $this->getTableFields())) {
                unset($data[$field]);
            }
        }
        return $data;
    }

    public function hydrate(array $data, AbstractModel $model = null, HydratorInterface $hydrator = null)
    {
        $hydrator = $hydrator ?: $this->getHydrator();
        $model    = $model    ?: $this->getModel();

        return $hydrator->hydrate($data, $model);
    }

    public function initPaginator($select, ResultSet\ResultSetInterface $resultSet = null)
    {
        $paginator = new Paginator(new PaginatorDbSelect($select, $this->getDbAdapter(), $resultSet));

        $options = $this->getPaginatorOptions();
        if (isset($options['n'])) {
            $paginator->setItemCountPerPage($options['n']);
        }
        if (isset($options['p'])) {
            $paginator->setCurrentPageNumber($options['p']);
        }

        return $paginator;
    }

    /**
     * @return hydrator
     */
    public function getHydrator()
    {
        if (is_string($this->hydrator) && class_exists($this->hydrator)) {
            return new $this->hydrator();
        }else{
            return new ClassMethods();
        }
    }

    /**
     * @param $hydrator
     * @return self
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
    }

    /**
     * @return model
     */
    public function getModel()
    {
        if (is_string($this->model) && class_exists($this->model)) {
            return new $this->model();
        }else{
            throw new \RuntimeException('could not instantiate model - ' . $this->model);
        }
    }

    /**
     * @param $model
     * @return self
     */
    public function setModel(AbstractModel $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Sql
     */
    protected function getSql($tableName = null)
    {
        if (!$this->sql instanceof Sql) {
            $this->sql = new Sql($this->getDbAdapter());
        }
        if ($tableName) {
            $this->sql->setTable($tableName);
        }

        return $this->sql;
    }

    /**
     * @param Sql
     * @return AbstractDbMapper
     */
    protected function setSql(Sql $sql)
    {
        $this->sql = $sql;
        return $this;
    }

    public function usePaginator(array $paginatorOptions = array())
    {
        $this->usePaginator = true;
        $this->paginatorOptions = $paginatorOptions;
        return $this;
    }

    /**
     * @return paginatorOptions
     */
    public function getPaginatorOptions()
    {
        return $this->paginatorOptions;
    }

    /**
     * @param $paginatorOptions
     * @return self
     */
    public function setPaginatorOptions($paginatorOptions)
    {
        $this->paginatorOptions = $paginatorOptions;
        return $this;
    }

    /**
     * @return dbAdapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

    /**
     * @param $dbAdapter
     * @return self
     */
    public function setDbAdapter(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }

    /**
     * @return tableName
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param $tableName
     * @return self
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * @return tableFields
     */
    public function getTableFields()
    {
        return $this->tableFields;
    }

    /**
     * @param $tableFields
     * @return self
     */
    public function setTableFields($tableFields)
    {
        $this->tableFields = $tableFields;
        return $this;
    }
}
