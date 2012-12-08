<?php

namespace SpeckCatalogTest;

use PHPUnit\Extensions\Database\TestCase;
use Zend\Db\Sql\Select;

class AbstractMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testInsertModelAbstract()
    {
        $product = $this->getTestProductModel();
        $mapper = $this->getMapper();

        $id = $mapper->insert($product);
        $this->assertTrue(is_numeric($id));
    }

    public function testInsertArray()
    {
        $product = array('name' => 'product');
        $mapper = $this->getMapper();

        $id = $mapper->insert($product);
        $this->assertTrue(is_numeric($id));
    }

    public function testUpdateWithArray()
    {
        $mapper = $this->getMapper();
        $id = $this->insertProduct();

        $data = array('name' => 'foo');
        $where = array('product_id' => $id);
        $mapper->update($data, $where);
        $product = $mapper->find($where);

        $this->assertTrue($product->getName() === 'foo');
    }

    public function testUpdateWithModelAbstract()
    {
        $mapper = $this->getMapper();
        $id = $this->insertProduct();

        $productModel = $this->getTestProductModel();
        $productModel->setName('foo');
        $productModel->setProductId($id);

        $where = array('product_id' => $id);
        $mapper->update($productModel, $where);
        $product = $mapper->find($where);

        $this->assertTrue($product->getName() === 'foo');
    }

    public function testSelectOneReturnsOneModelAbstract()
    {
        $mapper = $this->getMapper();

        $this->insertProduct();

        $select = new Select($mapper->getTableName());
        $select->where(array('name' => 'product'));
        $result = $mapper->selectOne($select);

        $this->assertTrue($result instanceOf \SpeckCatalog\Model\AbstractModel);
    }

    public function testSelectManyReturnsArrayOfModelAbstracts()
    {
        $mapper = $this->getMapper();

        $this->insertProduct();
        $this->insertProduct();

        $select = new Select($mapper->getTableName());
        $select->where(array('name' => 'product'));

        $result = $mapper->selectMany($select);

        $this->assertTrue(is_array($result));
        $this->assertTrue(count($result) > 1);
        $model = $result[0];
        $this->assertTrue($model instanceOf \SpeckCatalog\Model\AbstractModel);
    }

    public function testPrepareDataReturnsDbModelWhenPassedRelationalModel()
    {
        $mapper = $this->getMapper();
        $product = new \SpeckCatalog\Model\Product\Relational();
        $return = $mapper->prepareData($product, 'catalog_product');

        $this->assertTrue($return instanceOf \SpeckCatalog\Model\Product);
    }

    public function testPrepareDataWithArray()
    {
        $mapper = $this->getMapper();
        $dbFields = array('name');
        $mapper->setDbFields($dbFields);
        $data = array(
            'name' => 'foo',
            'bar' => 'baz' //this field will be stripped because it isnt in the db fields.
        );
        $return = $mapper->prepareData($data, 'catalog_product');
        $this->assertFalse(array_key_exists('bar', $return));
    }

    public function testPreparedDataReturnsSameWhenModelAlreadyPrepared()
    {
        $mapper = $this->getMapper();
        $product = $this->getTestProductModel();
        $return = $mapper->prepareData($product, 'catalog_product');
        $this->assertSame($product, $return);
    }

    public function testPrepareDataReturnsSameWhenTableDiffers()
    {
        $mapper = $this->getMapper();
        $product = $this->getTestProductModel();
        $return = $mapper->prepareData($product, 'foo_bar');
        $this->assertSame($product, $return);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPrepareDataThrowsInvalidArgumentExceptionWhenModelForDifferentTable()
    {
        $mapper = $this->getMapper();
        $option = new \SpeckCatalog\Model\Option;
        $return = $mapper->prepareData($option, 'catalog_product');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPrepareDataThrowsInvalidArgumentExceptionWhenDataNotArrayOrModelAbstract()
    {
        $mapper = $this->getMapper();
        $return = $mapper->prepareData('foo', 'catalog_product');
    }

    public function testQuery()
    {
        $this->insertProduct();
        $mapper = $this->getMapper();
        $select = new Select($mapper->getTableName());
        $select->where(array('name' => 'product'));
        $result = $mapper->query($select);
        $this->assertTrue($result['name'] === 'product');
    }

    public function testGetAll()
    {
        $this->insertProduct();
        $mapper = $this->getMapper();
        $products = $mapper->getAll();
        $this->assertTrue(count($products) > 0);
    }

    public function testUsePaginatorBeforeSelectManyReturnsZendPaginator()
    {
        $mapper = $this->getMapper();
        $this->insertProduct();
        $mapper->usePaginator(
            array('p' => 1, 'n' => 10) //optional params, passing them for code coverage
        );
        $result = $mapper->getAll();
        $this->assertTrue($result instanceOf \Zend\Paginator\Paginator);
    }

    public function testSetPaginatorOptions()
    {
        $mapper = $this->getMapper();
        $options = array('p' => 1, 'n' => 10);
        $mapper->setPaginatorOptions($options);
        $return = $mapper->getPaginatorOptions();
        $this->assertSame($options, $return);
    }





    /***
     * NOTE:
     * PHPUnit likes to hang when doing anything special
     * with Zend/ServiceManager...
     *
     * Workaround (for now):
     * The tests below change properties in the mapper,
     * they should be run last as to not interfere with
     * the other tests.
     *
     * NOTE
     */






    /**
     * @expectedException RuntimeException
     */
    public function testGetEntityPrototypeThrowsExceptionWhenRelationalModelPropertyIsNull()
    {
        $mapper = $this->getMapper();
        $mapper->setRelationalModel(null);
        $mapper->getEntityPrototype();
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetDbModelThrowsExceptionWhenRelationalDbModelPropertyIsNull()
    {
        $mapper = $this->getMapper();
        $mapper->setDbModel(null);
        $mapper->getDbModel();
    }

    public function testSetTableName()
    {
        $mapper = $this->getMapper();
        $name = 'foo';
        $mapper->setTableName($name);
        $this->assertSame($mapper->getTableName(), $name);
    }



    /**
     * NOTE
     * END OF TESTS
     * NOTE
     */


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
        $row = "insert into catalog_product ('name') VALUES ('product');";
        $db->query($row)->execute();
        $sql = "select * from catalog_product WHERE 1";
        $result = $db->query($row)->execute();
    }
}
