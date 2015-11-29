<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDocuments()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Document');
        $mockMapper->expects($this->once())
            ->method('getByProductId')
            ->with(1)
            ->will($this->returnValue([new \SpeckCatalog\Model\Document]));

        $service = $this->getService()
            ->setEntityMapper($mockMapper);

        $return = $service->getDocuments(1);

        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\Document', $return[0]);
    }

    public function getService()
    {
        return new \SpeckCatalog\Service\Document;
    }
}
