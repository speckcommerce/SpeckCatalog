<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class SitesTest extends \PHPUnit_Framework_TestCase
{
    public function testFoo()
    {
        $this->getService();
    }

    public function getService()
    {
        return new \SpeckCatalog\Service\Sites;
    }
}
