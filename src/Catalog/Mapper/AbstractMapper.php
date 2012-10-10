<?php

namespace Catalog\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Platform\Mysql;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Catalog\Adapter\PaginatorDbSelect;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class AbstractMapper extends AbstractDbMapper
{
    protected $paginator;
    protected $paginatorOptions;
    protected $usePaginator;

    protected function initialize()
    {
        //we're done here
    }

    public function selectOne(Select $select)
    {
        return $this->select($select)->current();
    }

    //always returns array
    public function selectMany(Select $select)
    {
        if($this->usePaginator) {
            $this->usePaginator = $false;
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
        $select = $this->getSelect()
            ->from($this->getTablename());
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

    public function getDbModel($construct)
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

    public function update($data, $where, $tableName = null, HydratorInterface $hydrator = null)
    {
        parent::update($data, $where, $tableName, $hydrator);
    }

    public function insert($model, $tableName = null, HydratorInterface $hydrator = null)
    {
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
}
