<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class AvailabilityTest extends AbstractTestCase
{
    public function testFindReturnsAvailabilityModel()
    {
        $this->insertAvailability(1, 'EA', 1, 1);
        $mapper = $this->getMapper();
        $data = [
            'product_id' => 1,
            'uom_code' => 'EA',
            'quantity' => 1,
            'distributor_id' => 1,
        ];
        $result = $mapper->find($data);
        $this->assertTrue($result instanceof \SpeckCatalog\Model\Availability);
    }

    public function testGetByProductUomReturnsArrayOfAvailabilityModels()
    {
        $this->insertAvailability(1, 'EA', 1, 1);
        $mapper = $this->getMapper();
        $result = $mapper->getByProductUom(1, 'EA', 1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof \SpeckCatalog\Model\Availability);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_availability_mapper');
    }
}
