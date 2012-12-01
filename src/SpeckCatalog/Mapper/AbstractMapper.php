<?php

namespace SpeckCatalog\Mapper;

use SpeckCatalog\Adapter\PaginatorDbSelect;
use SpeckCatalog\Mapper\DbAdapterAwareInterface;
use SpeckCatalog\Model\AbstractModel;
use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\Adapter\Platform\Mysql;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class AbstractMapper extends AbstractDbMapper implements DbAdapterAwareInterface
{
    protected $dbAdapter;
    protected $paginator;
    protected $paginatorOptions;
    protected $usePaginator;

    protected function initialize()
    {
        //$this->setEntityPrototype($this->getEntityPrototype());
        //parent::initialize();
        //we're done here - dont check anything, we got this covered
    }

    public function selectOne(Select $select)
    {
        return $this->select($select)->current();
    }

    //always returns array
    public function selectMany(Select $select)
    {
        if($this->usePaginator) {
            $this->usePaginator = false;
            $paginator = $this->initPaginator($select);
            return $paginator;
        }

        $result = $this->select($select);
        $return = array();
        if (count($result) > 0) {
            foreach($result as $res){
                $return[] = $res;
            }
        }
        return $return;
    }

    public function query($select)
    {
        $sql = $select->getSqlString(new Mysql);
        $result = $this->getDbAdapter()->query($sql)->execute()->current();
        return $result;
    }

    public function getAll()
    {
        $select = $this->getSelect($this->getTablename());
        return $this->selectMany($select);
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    //note: remove after zfcbase refactor
    public function getEntityPrototype()
    {
        if (is_string($this->relationalModel) && class_exists($this->relationalModel)) {
            return new $this->relationalModel;
        }else{
            die('could not instantiate - ' . $this->relationalModel);
        }
    }

    public function getDbModel(AbstractModel $construct)
    {
        if (is_string($this->dbModel) && class_exists($this->dbModel)) {
            return new $this->dbModel($construct);
        }else{
            die('could not instantiate - ' . $this->dbModel);
        }
    }

    //note: remove after zfcbase refactor
    public function getHydrator()
    {
        return new Hydrator;
    }

    public function where()
    {
        return new Where;
    }

    public function prepareData($data)
    {
        if ($data instanceof AbstractModel) {
            return $this->getDbModel($data);
        } elseif (is_array($data)) {
            $dbFields = $this->getDbFields();
            $return = array();
            foreach ($dbFields as $key) {
                if(array_key_exists($key, $data)) {
                    $return[$key] = $data[$key];
                }
            }
            return $return;
        }
    }

    public function update($data, $where, $tableName = null, HydratorInterface $hydrator = null)
    {
        $data = $this->prepareData($data);
        parent::update($data, $where, $tableName, $hydrator);
    }

    public function insert($model, $tableName = null, HydratorInterface $hydrator = null)
    {
        $model = $this->prepareData($model);
        if (null === $tableName) {
            $tableName = $this->getTableName();
        }
        $result = parent::insert($model, $tableName);
        return $result->getGeneratedValue();
    }

    public function usePaginator($options=array())
    {
        $this->usePaginator = true;
        $this->paginatorOptions = $options;
    }

    public function initPaginator($select)
    {
        $paginator = new Paginator(new PaginatorDbSelect(
            $select,
            $this->getDbAdapter(),
            new HydratingResultSet($this->getHydrator(), $this->getEntityPrototype())
        ));

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
     * @return paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * @param $paginator
     * @return self
     */
    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
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
    public function setDbAdapter(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }

    /**
     * @return dbFields
     */
    public function getDbFields()
    {
        return $this->dbFields;
    }

    /**
     * @param $dbFields
     * @return self
     */
    public function setDbFields($dbFields)
    {
        $this->dbFields = $dbFields;
        return $this;
    }
}
