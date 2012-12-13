<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\Asset\AbstractTestCase;

class FeatureTest extends AbstractTestCase
{
    //temp method just to include this mapper
    public function testInstantiate()
    {
        $mapper = $this->getMapper();
        $this->assertTrue($mapper instanceOf \SpeckCatalog\Mapper\Feature);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_feature_mapper');
    }
}
