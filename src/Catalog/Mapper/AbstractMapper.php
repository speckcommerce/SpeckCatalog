<?php

namespace Catalog\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Platform\Mysql;
use Zend\Stdlib\Hydrator\HydratorInterface;


class AbstractMapper extends AbstractDbMapper implements DbAdapterAwareInterface
{
    protected function initialize()
    {
        //we're done here
    }

    public function selectOne(Select $select)
    {
        $result = $this->select($select);
        if(count($result) === 1){
            return $result->current();
        } elseif(count($result) > 1) {
            throw new \Exception('returned more than one result');
        }
    }

    //always returns array
    public function selectMany(Select $select)
    {
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
    public function getEntityPrototype($constructor = null)
    {
        if (is_string($this->entityPrototype) && class_exists($this->entityPrototype)) {
            return new $this->entityPrototype($constructor);
        }else{
            die('could not instantiate - ' . $this->entityPrototype);
        }
    }

    //note: remove after zfcbase refactor
    public function getHydrator()
    {
        if (is_string($this->hydrator) && class_exists($this->hydrator)) {
            return new $this->hydrator;
        }else{
            die('could not instantiate - ' . $this->hydrator);
        }
    }

    public function where()
    {
        return new Where;
    }

    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        parent::update($entity, $where);
    }

    public function insert($model, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (null === $tableName) {
            $tableName = $this->getTableName();
        }
        $result = parent::insert($model, $tableName);
        return $result->getGeneratedValue();
    }
}
