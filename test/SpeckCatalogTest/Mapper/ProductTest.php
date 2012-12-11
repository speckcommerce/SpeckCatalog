<?php

namespace SpeckCatalogTest;

use PHPUnit\Extensions\Database\TestCase;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    protected $testMapper;

    public function testFindReturnsProduct()
    {
        $this->insertProduct();
        $data = array('product_id' => 1);

        $mapper = $this->getMapper();
        $return = $mapper->find($data);
        $this->assertTrue($return instanceOf \SpeckCatalog\Model\Product);
    }

    public function testGetByCategoryIdReturnsArrayOfProducts()
    {
        $this->insertProduct();
        $linker = array('category_id' => 1, 'website_id' => 1, 'product_id' => 1);
        $mapper = $this->getMapper();
        $mapper->insert($linker, 'catalog_category_product');

        $return = $mapper->getByCategoryId(1, 1);
        $this->assertTrue(is_array($return));
        $productModel = $return[0];
        $this->assertTrue($productModel instanceOf \SpeckCatalog\Model\Product);
    }

    public function testAddOptionCreatesLinker()
    {
        $optionId = $this->insertOption();
        $productId = $this->insertProduct();

        $mapper = $this->getMapper();
        $mapper->addOption($productId, $optionId);

        $table = 'catalog_product_option';
        $select = new \Zend\Db\Sql\Select($table);
        $select->where(array('product_id' => $productId, 'option_id' => $optionId));

        $result = $mapper->query($select);

        $this->assertTrue(is_array($result));
        $this->assertTrue($result['product_id'] == $productId);
        $this->assertTrue($result['option_id'] == $optionId);
    }

    public function testRemoveOptionRemovesLinker()
    {
        $optionId = $this->insertOption();
        $productId = $this->insertProduct();

        $mapper = $this->getMapper();
        $mapper->addOption($productId, $optionId);
        $mapper->removeOption($productId, $optionId);

        $table = 'catalog_product_option';
        $select = new \Zend\Db\Sql\Select($table);
        $select->where(array('product_id' => $productId, 'option_id' => $optionId));

        $result = $mapper->query($select);
        $this->assertFalse($result);
    }

    public function testSortOptionsChangesOrderOfOptions()
    {
        $table = 'catalog_product_option';
        $productId = 1;
        $linker1 = array('product_id' => $productId, 'option_id' => 3, 'sort_weight' => 0);
        $linker2 = array('product_id' => $productId, 'option_id' => 4, 'sort_weight' => 1);

        $mapper = $this->getMapper();
        $mapper->insert($linker1, $table);
        $mapper->insert($linker2, $table);

        $order = array(4,3);
        $mapper->sortOptions($productId, $order);

        $select = new \Zend\Db\Sql\Select($table);
        $select->where(array('option_id' => 4, 'sort_weight' => 0));

        $result = $mapper->query($select);

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
        $mapper = $this->getMapper();
        $product = array('name' => 'product');
        $id = $mapper->insert($product);
        return $id;
    }

    public function insertOption()
    {
        $mapper = $this->getMapper();
        $option = array('name' => 'option');
        $id = $mapper->insert($option);
        return $id;
    }

    public function setup()
    {
        $this->getTestMapper()->setup();
    }

    /**
     * @return testMapper
     */
    public function getTestMapper()
    {
        if (null === $this->testMapper) {
            $this->testMapper = $this->getServiceManager()->get('speckcatalog_test_mapper');
        }
        return $this->testMapper;
    }

    /**
     * @param $testMapper
     * @return self
     */
    public function setTestMapper($testMapper)
    {
        $this->testMapper = $testMapper;
        return $this;
    }
}
