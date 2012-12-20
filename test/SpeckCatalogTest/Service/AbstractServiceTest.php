<?php

namespace SpeckCatalogTest\Mapper;

use PHPUnit\Extensions\Database\TestCase;

class AbstractServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFindCallsFindOnMapper()
    {
        $mockedMapper = $this->getMock('\SpeckCatalog\Mapper\AbstractMapper');
        $mockedMapper->expects($this->once())
            ->method('find');

        $service = $this->getService();
        $service->setEntityMapper($mockedMapper);
        $data = array('return_model' => true);
        $service->find($data);
    }

    public function testPopulateReturnsInstanceOfModelParam()
    {
        $service = $this->getService();
        $return = $service->populate(new \SpeckCatalog\Model\Product());
        $this->assertTrue($return instanceOf \SpeckCatalog\Model\Product);
    }

    public function testGetEntity()
    {
    }

    public function getService()
    {
        return new \SpeckCatalogTest\Service\TestAsset\ChildAbstractService();
    }
}
