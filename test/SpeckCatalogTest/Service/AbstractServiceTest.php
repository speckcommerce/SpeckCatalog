<?php

namespace SpeckCatalogTest\Service;

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
        $data = ['return_model' => true];
        $service->find($data);
    }

    public function testPopulateReturnsInstanceOfModelParam()
    {
        $service = $this->getService();
        $return = $service->populate(new \SpeckCatalog\Model\Product());
        $this->assertTrue($return instanceof \SpeckCatalog\Model\Product);
    }

    public function testGetEntity()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $mockedMapper = $this->getMock('\SpeckCatalog\Mapper\AbstractMapper');
        $mockedMapper->expects($this->once())
            ->method('getEntityPrototype');
        $service = $this->getService();
        $service->setEntityMapper($mockedMapper);
        $service->getEntity();
    }

    public function testGetEntityMapperCallsGetOnServiceLocator()
    {
        $mockedServiceLocator = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockedServiceLocator->expects($this->once())
            ->method('get')
            ->with('foo_bar_mapper');
        $service = $this->getService();
        $service->setServiceLocator($mockedServiceLocator);
        $service->setEntityMapper('foo_bar_mapper');
        $service->getEntityMapper();
    }

    public function testGetAllCallsGetAllOnMapper()
    {
        $mockedMapper = $this->getMock('\SpeckCatalog\Mapper\AbstractMapper');
        $mockedMapper->expects($this->once())
            ->method('getAll');
        $service = $this->getService();
        $service->setEntityMapper($mockedMapper);
        $service->getAll();
    }

    public function testInsertCallsInsertOnMapper()
    {
        $mockedMapper = $this->getMock('\SpeckCatalog\Mapper\AbstractMapper');
        $mockedMapper->expects($this->once())
            ->method('insert');
        $service = $this->getService();
        $service->setEntityMapper($mockedMapper);
        $service->insert([]);
    }

    public function testUpdateCallsUpdateOnMapper()
    {
        $mockedMapper = $this->getMock('\SpeckCatalog\Mapper\AbstractMapper');
        $mockedMapper->expects($this->once())
            ->method('update');
        $service = $this->getService();
        $service->setEntityMapper($mockedMapper);
        $service->update([]);
    }

    public function getService()
    {
        return new \SpeckCatalogTest\Service\TestAsset\ChildAbstractService();
    }
}
