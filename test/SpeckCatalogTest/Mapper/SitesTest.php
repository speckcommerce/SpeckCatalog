<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\Asset\AbstractTestCase;

class SitesTest extends AbstractTestCase
{
    //temporary test just to include this mapper
    public function testInstantiate()
    {
        $mapper = $this->getMapper();
        $this->assertTrue($mapper instanceOf \SpeckCatalog\Mapper\Sites);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_sites_mapper');
    }
}
