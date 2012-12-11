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

    public function setup()
    {
        $this->getTestMapper()->setup();
    }

    public function teardown()
    {
        $this->getTestMapper()->teardown();
    }
}
