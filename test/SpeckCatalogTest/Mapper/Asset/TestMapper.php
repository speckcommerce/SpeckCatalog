<?php

namespace SpeckCatalogTest\Mapper\Asset;

use ZfcBase\Mapper\AbstractDbMapper;

class TestMapper extends AbstractDbMapper
{
    protected $schema = array();

    protected $serviceManager;

    protected $dbAdapter;

    public function setup()
    {
        foreach ($this->getSchema() as $statement) {
            $this->getDbAdapter()->query($statement)->execute();
        };
    }

    public function teardown()
    {
        foreach ($this->getSchema() as $tableName => $statement) {
        };
    }

    //PUBLIC
    public function insert($data, $tableName=NULL, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = NULL)
    {
        return parent::insert($data, $tableName);
    }

    public function query(\Zend\Db\Sql\Select $select)
    {
        $dbAdapter = $this->getDbAdapter();
        $platform = $dbAdapter->getPlatform();
        $sql = $select->getSqlString($platform);
        $result = $dbAdapter->query($sql)->execute()->current();
        return $result;
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
    public function setDbAdapter(\Zend\Db\Adapter\Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }

    /**
     * @return schema
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param $schema
     * @return self
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
        return $this;
    }

    /**
     * @return serviceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param $serviceManager
     * @return self
     */
    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}
