<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class SpecTest extends \PHPUnit_Framework_TestCase
{
    public function testFindCallsFindOnMapperThenPopulatesAndReturnsSpec()
    {
        $spec = new \SpeckCatalog\Model\Spec\Relational;
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Spec');
        $mockMapper->expects($this->once())
            ->method('find')
            ->with(array('spec_id' => 1))
            ->will($this->returnValue($spec));

        $service = $this->getMock('\SpeckCatalog\Service\Spec', array('populate'));
        $service->expects($this->once())
            ->method('populate')
            ->with($spec)
            ->will($this->returnValue($spec));

        $service->setEntityMapper($mockMapper);
        $return = $service->find(array('spec_id' => 1), 1);
        $this->assertInstanceOf('\SpeckCatalog\Model\Spec', $return);
    }

    public function testGetByProductIdCallsGetByProductIdOnMapperAndReturnsArrayOfSpecModels()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Spec');
        $mockMapper->expects($this->once())
            ->method('getByProductId')
            ->with(1)
            ->will($this->returnValue(array(new \SpeckCatalog\Model\Spec)));

        $service = $this->getService()
            ->setEntityMapper($mockMapper);

        $return = $service->getByProductId(1);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\Spec', $return[0]);
    }

    public function testInsertCallsInsertOnParentAndReturnsSpecModel()
    {
        $spec = new \SpeckCatalog\Model\Spec;
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Spec');
        $mockMapper->expects($this->once())
            ->method('insert')
            ->with($spec)
            ->will($this->returnValue(77));
        $mockMapper->expects($this->once())
            ->method('find')
            ->with(array('spec_id' => 77))
            ->will($this->returnValue($spec));

        $service = $this->getService()
            ->setEntityMapper($mockMapper);
        $return = $service->insert($spec);
        $this->assertInstanceOf('\SpeckCatalog\Model\Spec', $return);
    }

    public function getService()
    {
        return new \SpeckCatalog\Service\Spec;
    }
}
