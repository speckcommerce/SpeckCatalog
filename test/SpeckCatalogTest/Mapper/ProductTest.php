<?php

namespace SpeckCatalogTest;

use PHPUnit\Extensions\Database\TestCase;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    protected $testMapper;

    public function testFindReturnsProduct()
    {
        $productId = $this->insertProduct();

        $mapper = $this->getMapper();
        $return = $mapper->find(array('product_id' => $productId));
        $this->assertTrue($return instanceOf \SpeckCatalog\Model\Product);
    }

    public function testGetByCategoryIdReturnsArrayOfProducts()
    {
        $productId = $this->insertProduct();
        $linker = array('category_id' => 1, 'website_id' => 1, 'product_id' => $productId);
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_category_product');

        $mapper = $this->getMapper();
        $return = $mapper->getByCategoryId(1, 1);
        $this->assertTrue(is_array($return));
        $this->assertTrue($return[0] instanceOf \SpeckCatalog\Model\Product);
    }

    public function testAddOptionCreatesLinker()
    {
        $optionId = $this->insertOption();
        $productId = $this->insertProduct();
        $mapper = $this->getMapper();
        $mapper->addOption($productId, $optionId);

        $select = new \Zend\Db\Sql\Select('catalog_product_option');
        $select->where(array('product_id' => $productId, 'option_id' => $optionId));
        $testMapper = $this->getTestMapper();
        $result = $testMapper->query($select);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result['product_id'] == $productId);
        $this->assertTrue($result['option_id'] == $optionId);
    }

    public function testRemoveOptionRemovesLinker()
    {
        $optionId = $this->insertOption();
        $productId = $this->insertProduct();
        $testMapper = $this->getTestMapper();
        $linker = array('product_id' => $productId, 'option_id' => $optionId);
        $testMapper->insert($linker, 'catalog_product_option');

        $mapper = $this->getMapper();
        $mapper->removeOption($productId, $optionId);

        $select = new \Zend\Db\Sql\Select('catalog_product_option');
        $select->where(array('product_id' => $productId, 'option_id' => $optionId));
        $result = $testMapper->query($select);
        $this->assertFalse($result);
    }

    public function testSortOptionsChangesOrderOfOptions()
    {
        $table = 'catalog_product_option';
        $productId = 1;
        $linker1 = array('product_id' => $productId, 'option_id' => 3, 'sort_weight' => 0);
        $linker2 = array('product_id' => $productId, 'option_id' => 4, 'sort_weight' => 1);
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker1, $table);
        $testMapper->insert($linker2, $table);

        $order = array(4,3);
        $mapper = $this->getMapper();
        $mapper->sortOptions($productId, $order);

        $select = new \Zend\Db\Sql\Select($table);
        $select->where(array('option_id' => 4, 'sort_weight' => 0));
        $result = $testMapper->query($select);
        $this->assertTrue(is_array($result));
    }

    public function getMapper()
    {
        $mapper =  $this->getServiceManager()->get('speckcatalog_product_mapper');
        return $mapper;
    }

    public function getServiceManager()
    {
        return \SpeckCatalogTest\Bootstrap::getServiceManager();
    }

    public function getTestProductModel()
    {
        $product = new \SpeckCatalog\Model\Product();
        $product->setName('product')
            ->setManufacturerId(1);
        return $product;
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

    public function setup()
    {
        $this->getTestMapper()->setup();
    }

    public function getTestMapper()
    {
        if (null === $this->testMapper) {
            $this->testMapper = $this->getServiceManager()->get('speckcatalog_test_mapper');
        }
        return $this->testMapper;
    }

    public function setTestMapper($testMapper)
    {
        $this->testMapper = $testMapper;
        return $this;
    }
}
