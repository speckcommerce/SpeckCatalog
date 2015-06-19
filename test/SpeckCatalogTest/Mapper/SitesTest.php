<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class SitesTest extends AbstractTestCase
{
    //temporary test just to include this mapper
    public function testInstantiate()
    {
        $mapper = $this->getMapper();
        $this->assertTrue($mapper instanceof \SpeckCatalog\Mapper\Sites);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_sites_mapper');
    }
}
