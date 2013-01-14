<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class FeatureTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFeaturesCallsGetByProductIdOnMapperAndReturnsArrayOfFeatureModels()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Feature');
        $mockMapper->expects($this->once())
            ->method('getByProductId')
            ->with(1)
            ->will($this->returnValue(array(new \SpeckCatalog\Model\Feature)));

        $service = $this->getService()
            ->setEntityMapper($mockMapper);

        $return = $service->getFeatures(1);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\Feature', $return[0]);
    }

    public function getService()
    {
        return new \SpeckCatalog\Service\Feature;
    }
}
