<?php

namespace SpeckCatalogTest\Mapper;

class ProductUomTest extends AbstractTestCase
{
    public function testFindReturnsProductUomModel()
    {
        $this->insertProductUom(1, 'EA', 1);
        $mapper = $this->getMapper();
        $result = $mapper->find(array('product_id' => 1, 'uom_code' => 'EA', 'quantity' => 1));
        $this->assertTrue($result instanceOf \SpeckCatalog\Model\ProductUom);
    }

    public function testGetByProductIdReturnsArrayOfProductUomModels()
    {
        $this->insertProductUom(1, 'EA', 1);
        $mapper = $this->getMapper();
        $result = $mapper->getByProductId(1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceOf \SpeckCatalog\Model\ProductUom);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_product_uom_mapper');
    }
}
