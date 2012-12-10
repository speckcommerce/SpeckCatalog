<?php

namespace SpeckCatalogTest;

use PHPUnit\Extensions\Database\TestCase;

class ProductTest extends \PHPUnit_Framework_TestCase
{
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
        $this->createCategoryProductTable();
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
        $this->createOptionTables();

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
        $this->createOptionTables();

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
        $this->createOptionTables();
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
        $this->createProductTable();
        $db = $this->getServiceManager()->get('speckcatalog_db');
        $row = "insert into catalog_product ('name') VALUES ('product');";
        $db->query($row)->execute();
        $sql = "select * from catalog_product WHERE 1";
        $result = $db->query($row)->execute();
    }

    public function createProductTable()
    {
        $query = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product`(
    `product_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    'name'            VARCHAR(255),
    'description'     VARCHAR(255),
    'manufacturer_id' INTEGER(11),
    'item_number'     VARCHAR(255),
    'product_type_id' INTEGER(1)
);
sqlite;
        $db = $this->getServiceManager()->get('speckcatalog_db');
        $db->query($query)->execute();
    }

    public function createCategoryProductTable()
    {
        $query = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_category_product`(
    `product_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    `category_id`     INTEGER(11),
    `website_id`      INTEGER(11)
);
sqlite;
        $db = $this->getServiceManager()->get('speckcatalog_db');
        $db->query($query)->execute();
    }

    public function createOptionTables()
    {
        $option = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_option`(
    `option_id`       INTEGER PRIMARY KEY AUTOINCREMENT,
    `name`            VARCHAR(255),
    `instruction`     VARCHAR(255),
    `required`        INTEGER(1),
    `variation`       INTEGER(1),
    `option_type_id`  INTEGER(1)
);
sqlite;

        $linker = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product_option`(
    `product_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    `option_id`       INTEGER(11),
    `sort_weight`     INTEGER(11)
);
sqlite;

        $db = $this->getServiceManager()->get('speckcatalog_db');
        $db->query($option)->execute();
        $db->query($linker)->execute();
    }
}
