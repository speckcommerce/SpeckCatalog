<?php

namespace SpeckCatalogTest\Mapper;

use PHPUnit\Extensions\Database\TestCase;

class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    protected $testMapper;

    public function getTestMapper()
    {
        if (null === $this->testMapper) {
            $this->testMapper =  $this->getServiceManager()->get('speckcatalog_test_mapper');
        }
        return $this->testMapper;
    }

    public function getServiceManager()
    {
        return \SpeckCatalogTest\Bootstrap::getServiceManager();
    }

    public function insertProduct()
    {
        $mapper = $this->getTestMapper();
        $mapper->setEntityPrototype(new \SpeckCatalog\Model\Product);
        $product = array('name' => 'product');
        $result = $mapper->insert($product, 'catalog_product');
        return (int) $result->getGeneratedValue();
    }

    public function insertOption()
    {
        $mapper = $this->getTestMapper();
        $mapper->setEntityPrototype(new \SpeckCatalog\Model\Option);
        $option = array('name' => 'option');
        $result = $mapper->insert($option, 'catalog_option');
        return (int) $result->getGeneratedValue();
    }

    public function setup()
    {
        $this->getTestMapper()->setup();
    }

    public function teardown()
    {
        $this->getTestMapper()->teardown();
    }
}
