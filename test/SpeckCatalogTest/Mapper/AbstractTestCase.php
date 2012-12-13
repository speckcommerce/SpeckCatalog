<?php

namespace SpeckCatalogTest\Mapper;

use PHPUnit\Extensions\Database\TestCase;

class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    protected $testMapper;

    public function getTestMapper()
    {
        if (null === $this->testMapper) {
            $this->testMapper =  $this->getServiceManager()->get('speckcatalog_test_mapper');
        }
        return $this->testMapper;
    }

    public function getServiceManager()
    {
        return \SpeckCatalogTest\Bootstrap::getServiceManager();
    }

    public function insertProduct()
    {
        $mapper = $this->getTestMapper();
        $mapper->setEntityPrototype(new \SpeckCatalog\Model\Product);
        $product = array('name' => 'product');
        $result = $mapper->insert($product, 'catalog_product');
        return (int) $result->getGeneratedValue();
    }

    public function insertOption()
    {
        $mapper = $this->getTestMapper();
        $mapper->setEntityPrototype(new \SpeckCatalog\Model\Option);
        $option = array('name' => 'option');
        $result = $mapper->insert($option, 'catalog_option');
        return (int) $result->getGeneratedValue();
    }

    public function insertChoice($parentOptionId)
    {
        $mapper = $this->getTestMapper();
        $mapper->setEntityProtoType(new \SpeckCatalog\Model\Choice);
        $choice = array('option_id' => $parentOptionId);
        $result = $mapper->insert($choice, 'catalog_choice');
        return (int) $result->getGeneratedValue();
    }

    public function insertProductUom($productId, $uomCode, $quantity)
    {
        $productUom = array(
            'product_id' => $productId,
            'uom_code'   => $uomCode,
            'quantity'   => $quantity,
            'price'      => 1,
            'retail'     => 1,
        );
        $mapper = $this->getTestMapper();
        $mapper->insert($productUom, 'catalog_product_uom');
    }

    public function insertAvailability($productId, $uomCode, $quantity, $distributorId)
    {
        $availability = array(
            'product_id'     => $productId,
            'uom_code'       => $uomCode,
            'quantity'       => $quantity,
            'distributor_id' => $distributorId,
            'cost'           => 1,
        );
        $mapper = $this->getTestMapper();
        $mapper->insert($availability, 'catalog_availability');
    }

    public function insertImage($parentType, $parentId=1)
    {
        $mapper = $this->getTestMapper();
        $idName = $parentType . '_id';
        $image = array($idName => $parentId);
        $table = 'catalog_' . $parentType . '_image';
        $result = $mapper->insert($image, $table);
        return (int) $result->getGeneratedValue();
    }

    public function insertCategory()
    {
        $category = array('name' => 'category');
        $mapper = $this->getTestMapper();
        $result = $mapper->insert($category, 'catalog_category');
        return (int) $result->getGeneratedValue();
    }

    public function insertDocument($parentProductId=1)
    {
        $document = array('product_id' => $parentProductId);
        $mapper = $this->getTestMapper();
        $result = $mapper->insert($document, 'catalog_product_document');
        return (int) $result->getGeneratedValue();
    }

    public function insertSpec($parentProductId=1)
    {
        $spec = array('product_id' => $parentProductId);
        $mapper = $this->getTestMapper();
        $result = $mapper->insert($spec, 'catalog_product_spec');
        return (int) $result->getGeneratedValue();
    }

    public function insertUom($uomCode, $name)
    {
        $uom = array('uom_code' => $uomCode, 'name' => $name);
        $mapper = $this->getTestMapper();
        $result = $mapper->insert($uom, 'ansi_uom');
    }

    public function setup()
    {
        $this->getTestMapper()->setup();
    }

    public function teardown()
    {
        $this->getTestMapper()->teardown();
    }
}
