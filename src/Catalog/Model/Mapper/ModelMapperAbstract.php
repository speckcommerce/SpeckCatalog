<?php

namespace Catalog\Model\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Catalog\Model\Mapper\Hydrator;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\Sql\Select;

class ModelMapperAbstract extends AbstractDbMapper
{
    protected $tableName;
    protected $hydrator;

    public function __construct($adapter, $unsetFields=null)
    {
        if(null === $unsetFields){
            $unsetFields = array();
        }
        $this->setDbAdapter($adapter);
        $this->setEntityPrototype($this->getModel());
        $this->setHydrator(new Hydrator($unsetFields));
    }

    public function getAll()
    {
        $select = $this->select()
                       ->from($this->getTablename());

        $result = $this->selectwith($select);
        if(null === $result){
            $result = array();
        }
        return $result;
    }

    public function findById($id)
    {
        $select = $this->select()
                       ->from($this->getTablename())
                       ->where(array('record_id' => $id));
        return $this->selectwith($select);
    }

    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'record_id = ' . $entity->getRecordId();
        }

        return parent::update($entity, $where, $tableName, $hydrator);
    }

    public function add($model)
    {
        $result = parent::insert($model, $this->getTableName());
        $model->setRecordId($result->getGeneratedValue());
        return $model;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function selectWith(Select $select, $entityPrototype = null, HydratorInterface $hydrator = null)
    {
        $result = parent::selectWith($select, $entityPrototype, $hydrator);

        if(count($result) === 1){
            return $result->current();
        }
    }

    public function selectMany(Select $select, $entityPrototype = null, HydratorInterface $hydrator = null)
    {
        $result = parent::selectWith($select, $entityPrototype, $hydrator);

        if(count($result) > 0){
            $return = array();
            foreach($result as $res){
                $return[] = $res;
            }
            return $return;
        }
        return array();
    }
}
