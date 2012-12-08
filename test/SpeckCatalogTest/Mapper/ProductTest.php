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
        $this->assertTrue(count($return) > 0);
        $productModel = $return[0];
        $this->assertTrue($productModel instanceOf \SpeckCatalog\Model\Product);
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
);";
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
);";
sqlite;
        $db = $this->getServiceManager()->get('speckcatalog_db');
        $db->query($query)->execute();
    }

}
