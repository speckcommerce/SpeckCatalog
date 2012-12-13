<?php

namespace SpeckCatalogTest\Mapper;
use SpeckCatalogTest\Mapper\Asset\AbstractTestCase;

class SpecTest extends AbstractTestCase
{
    public function testFindReturnsSpecModel()
    {
        $id = $this->insertSpec();
        $mapper = $this->getMapper();
        $return = $mapper->find(array('spec_id' => $id));
        $this->assertTrue($return instanceOf \SpeckCatalog\Model\Spec);
    }

    public function testGetByProductIdReturnsArrayOfSpecModels()
    {
        $this->insertSpec(1);
        $mapper = $this->getMapper();
        $return = $mapper->getByProductId(1);
        $this->assertTrue(is_array($return));
        $this->assertTrue($return[0] instanceOf \SpeckCatalog\Model\Spec);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_spec_mapper');
    }
}
