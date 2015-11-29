<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class FeatureTest extends AbstractTestCase
{
    //temp method just to include this mapper
    public function testInstantiate()
    {
        $mapper = $this->getMapper();
        $this->assertTrue($mapper instanceof \SpeckCatalog\Mapper\Feature);
    }

    public function testGetByProductIdReturnsArrayOfFeatureModels()
    {
        $testMapper = $this->getTestMapper();
        $testMapper->insert(['product_id' => 88], 'catalog_product_feature');

        $mapper = $this->getMapper();
        $return = $mapper->getByProductId(88);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\Feature', $return[0]);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_feature_mapper');
    }
}
