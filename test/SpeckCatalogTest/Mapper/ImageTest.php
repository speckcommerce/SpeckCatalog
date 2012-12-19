<?php

namespace SpeckCatalogTest\Mapper;
use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class ImageTest extends AbstractTestCase
{
    public function testSetParentTypeSetsUpTableNameAndRelationalModelAndDbModel()
    {
        $mapper = $this->getMapper();
        $mapper->setParentType('product');

        $this->assertTrue($mapper->getEntityPrototype() instanceOf \SpeckCatalog\Model\ProductImage\Relational);
        $this->assertTrue($mapper->getDbModel() instanceOf \SpeckCatalog\Model\ProductImage);
        $this->assertTrue($mapper->getTableName() === 'catalog_product_image');
    }

    public function testFindReturnsModelAbstract()
    {
        $imageId = $this->insertImage('product');

        $mapper = $this->getMapper();
        $mapper->setParentType('product');
        $return = $mapper->find(array('image_id' => $imageId));
        $this->assertTrue($return instanceOf \SpeckCatalog\Model\ProductImage);
    }

    public function testGetImagesReturnsArrayOfModelAbstracts()
    {
        $this->insertImage('product', 1);

        $mapper = $this->getMapper();
        $mapper->setParentType('product');

        $return = $mapper->getImages('product', 1);
        $this->assertTrue(is_array($return));
        $this->assertTrue($return[0] instanceOf \SpeckCatalog\Model\ProductImage);
    }

    public function testGetParentTypeReturnsParentTypeString()
    {
        $mapper = $this->getMapper();
        $mapper->setParentType('product');
        $this->assertEquals('product' , $mapper->getParentType());
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_image_mapper');
    }
}
