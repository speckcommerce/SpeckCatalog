<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetImagesCallsGetImagesOnMapperAndReturnsArrayOfImageModels()
    {
        $image = new \SpeckCatalog\Model\ProductImage;
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Image');
        $mockMapper->expects($this->once())
            ->method('getImages')
            ->with('product', 1)
            ->will($this->returnValue(array($image)));

        $service = $this->getService()
            ->setEntityMapper($mockMapper);
        $return = $service->getImages('product', 1);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\ProductImage', $return[0]);
    }

    public function testGetImageForCategoryIdReturnsImageModel()
    {
        $image = new \SpeckCatalog\Model\ProductImage;
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Image');
        $mockMapper->expects($this->once())
            ->method('getImages')
            ->with('category', 1)
            ->will($this->returnValue(array($image)));

        $service = $this->getService()
            ->setEntityMapper($mockMapper);
        $return = $service->getImageForCategory(1);
        $this->assertInstanceOf('\SpeckCatalog\Model\ProductImage', $return);
    }


    public function getService()
    {
        return new \SpeckCatalog\Service\Image;
    }
}
