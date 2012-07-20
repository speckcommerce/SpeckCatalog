<?php

namespace Catalog\Model\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Catalog\Model\Mapper\Hydrator;
use Zend\Stdlib\Hydrator\HydratorInterface;

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

        $entity = $this->selectwith($select)->current();
        $this->geteventmanager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function findById($id)
    {
        $select = $this->select()
                       ->from($this->getTablename())
                       ->where(array('record_id' => $id));

        $entity = $this->selectwith($select)->current();
        $this->geteventmanager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
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
}
