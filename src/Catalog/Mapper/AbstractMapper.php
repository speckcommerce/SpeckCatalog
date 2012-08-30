<?php

namespace Catalog\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class AbstractMapper extends AbstractDbMapper implements DbAdapterAwareInterface
{
    public function selectOne(Select $select)
    {
        $result = $this->selectWith($select);
        if(count($result) === 1){
            return $result->current();
        } elseif(count($result) > 1) {
            throw new \Exception('returned more than one result');
        }
    }

    //always returns array
    public function selectMany(Select $select)
    {
        $result = $this->selectWith($select);

        $return = array();
        if (count($result) > 0) {
            foreach($result as $res){
                $return[] = $res;
            }
        }
        return $return;
    }

    public function getAll()
    {
        $select = $this->select()
            ->from($this->getTablename());
        return $this->selectMany($select);
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    //note: remove after zfcbase refactor
    public function getEntityPrototype()
    {
        if (is_string($this->entityPrototype) && class_exists($this->entityPrototype)) {
            $this->entityPrototype = new $this->entityPrototype;
        }else{
            die('could not instantiate - ' . $this->entityPrototype);
        }
        return parent::getEntityPrototype();
    }

    //note: remove after zfcbase refactor
    public function getHydrator()
    {
        if (is_string($this->hydrator) && class_exists($this->hydrator)) {
            $this->hydrator = new $this->hydrator;
        }else{
            die('could not instantiate - ' . $this->hydrator);
        }
        return parent::getHydrator();
    }

    public function select()
    {
        return new Select;
    }

    public function where()
    {
        return new Where;
    }
}
