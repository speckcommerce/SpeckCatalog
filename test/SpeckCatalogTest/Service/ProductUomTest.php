<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class ProductUomTest extends \PHPUnit_Framework_TestCase
{

    public function testGetByProductIdReturnsArrayOfProductUoms()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\ProductUom');
        $mockProductUom = $this->getMockProductUom();
        $mockMapper->expects($this->once())
            ->method('getByProductId')
            ->with(1)
            ->will($this->returnValue([$mockProductUom]));
        $service = $this->getService()
            ->setEntityMapper($mockMapper)
            ->setAvailabilityService($this->getMockAvailabilityService())
            ->setUomService($this->getMockUomService());

        $return = $service->getByProductId(1, true);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\ProductUom', $return[0]);
    }

    public function testPopulate()
    {
        $service = $this->getService()
            ->setAvailabilityService($this->getMockAvailabilityService())
            ->setUomService($this->getMockUomService());

        $service->populate($this->getMockProductUom());
    }

    public function getService()
    {
        return new \SpeckCatalog\Service\ProductUom;
    }

    public function testGetAvailabilityService()
    {
        $mockAvailabilityService = new \SpeckCatalog\Service\Availability;
        $service = $this->getService();
        $service->setAvailabilityService($mockAvailabilityService);
        $return = $service->getAvailabilityService();
        $this->assertInstanceof('\SpeckCatalog\Service\Availability', $return);
    }

    public function testGetAvailabilityServiceGetsAvailabilityServiceFromServiceManager()
    {
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_availability_service');
        $service = $this->getService();
        $service->setServiceLocator($mockServiceManager);
        $service->getAvailabilityService();
    }

    public function testGetUomService()
    {
        $mockUomService = new \SpeckCatalog\Service\Uom;
        $service = $this->getService();
        $service->setUomService($mockUomService);
        $return = $service->getUomService();
        $this->assertInstanceof('\SpeckCatalog\Service\Uom', $return);
    }

    public function testGetUomServiceGetsUomServiceFromServiceManager()
    {
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_uom_service');
        $service = $this->getService();
        $service->setServiceLocator($mockServiceManager);
        $service->getUomService();
    }

    public function testInsertWithModelCallsInsertOnParentAndReturnsModel()
    {
        $data = ['product_id' => 1, 'uom_code' => 'EA', 'quantity' => 1];
        $productUom = new \SpeckCatalog\Model\ProductUom;
        $productUom->setProductId(1)
            ->setUomCode('EA')
            ->setQuantity(1);

        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\ProductUom');
        $mockMapper->expects($this->once())
            ->method('insert')
            ->with($productUom);
        $mockMapper->expects($this->once())
            ->method('find')
            ->with($data)
            ->will($this->returnValue($productUom));

        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $return = $service->insert($productUom);
        $this->assertInstanceOf('\SpeckCatalog\Model\ProductUom', $return);
    }

    public function testInsertWithArrayGeneratesCorrectValuesForFind()
    {
        $data = ['product_id' => 1, 'uom_code' => 'EA', 'quantity' => 1];
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\ProductUom');
        $mockMapper->expects($this->once())
            ->method('insert')
            ->with($data);
        $mockMapper->expects($this->once())
            ->method('find')
            ->with($data);

        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->insert($data);
    }

    public function getMockProductUom()
    {
        $productUom = $this->getMock('\SpeckCatalog\Model\ProductUom\Relational');
        $uom = new \SpeckCatalog\Model\Uom;
        $availability = new \SpeckCatalog\Model\Availability;
        $productUom->expects($this->any())
            ->method('getProductId')
            ->will($this->returnValue(1));
        $productUom->expects($this->any())
            ->method('getUomCode')
            ->will($this->returnValue('EA'));
        $productUom->expects($this->any())
            ->method('getQuantity')
            ->will($this->returnValue(1));
        $productUom->expects($this->once()) //this is expected by populate() dont change
            ->method('setAvailabilities')
            ->with([$availability])
            ->will($this->returnValue($productUom));
        $productUom->expects($this->once()) //this is expected by populate() dont change
            ->method('setUom')
            ->with($uom)
            ->will($this->returnValue($productUom));
        return $productUom;
    }

    public function getMockUomService()
    {
        $uom = new \SpeckCatalog\Model\Uom;
        $mockUomService = $this->getMock('\SpeckCatalog\Service\Uom');
        $mockUomService->expects($this->once()) // expected by populate(), dont change
            ->method('find')
            ->with(['uom_code' => 'EA'])
            ->will($this->returnValue($uom));
        return $mockUomService;
    }

    public function getMockAvailabilityService()
    {
        $mockAvailabilityService = $this->getMock('\SpeckCatalog\Service\Availability');
        $availability = new \SpeckCatalog\Model\Availability;
        $mockAvailabilityService->expects($this->any())
            ->method('getByProductUom')
            ->with(1, 'EA', 1)
            ->will($this->returnValue([$availability]));
        return $mockAvailabilityService;
    }
}
