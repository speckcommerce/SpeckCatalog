<?php

namespace SpeckCatalogTest\Mapper;

use Zend\Db\Sql\Select;
use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class AbstractMapperTest extends AbstractTestCase
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
        $testMapper = $this->getTestMapper();
        $id = $this->insertProduct();

        $data = array('name' => 'foo');
        $where = array('product_id' => $id);
        $mapper->update($data, $where);

        $select = new Select('catalog_product');
        $select->where($where);
        $product = $testMapper->query($select);

        $this->assertTrue($product['name'] === 'foo');
    }

    public function testUpdateWithModelAbstract()
    {
        $testMapper = $this->getTestMapper();
        $mapper = $this->getMapper();
        $id = $this->insertProduct();

        $productModel = $this->getTestProductModel();
        $productModel->setName('foo');
        $productModel->setProductId($id);

        $where = array('product_id' => $id);
        $mapper->update($productModel, $where);

        $select = new Select('catalog_product');
        $select->where($where);
        $product = $testMapper->query($select);

        $this->assertTrue($product['name'] === 'foo');
    }

    public function testSelectOneReturnsOneModelAbstract()
    {
        $mapper = $this->getMapper();

        $this->insertProduct();

        $select = new Select($mapper->getTableName());
        $select->where(array('name' => 'product'));
        $result = $mapper->selectOne($select);

        $this->assertTrue($result instanceof \SpeckCatalog\Model\AbstractModel);
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
        $this->assertTrue($model instanceof \SpeckCatalog\Model\AbstractModel);
    }

    public function testPrepareDataReturnsDbModelWhenPassedRelationalModel()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $mapper = $this->getMapper();
        $product = new \SpeckCatalog\Model\Product\Relational();
        $return = $mapper->prepareData($product, 'catalog_product');

        $this->assertTrue($return instanceof \SpeckCatalog\Model\Product);
    }

    public function testPrepareDataWithArray()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
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
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $mapper = $this->getMapper();
        $product = new \SpeckCatalog\Model\Product;
        $return = $mapper->prepareData($product, 'catalog_product');
        $this->assertSame($product, $return);
    }

    public function testPrepareDataReturnsSameWhenTableDiffers()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $mapper = $this->getMapper();
        $product = new \SpeckCatalog\Model\Product;
        $return = $mapper->prepareData($product, 'foo_bar');
        $this->assertSame($product, $return);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPrepareDataThrowsInvalidArgumentExceptionWhenModelForDifferentTable()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $mapper = $this->getMapper();
        $option = new \SpeckCatalog\Model\Option;
        $return = $mapper->prepareData($option, 'catalog_product');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPrepareDataThrowsInvalidArgumentExceptionWhenDataNotArrayOrModelAbstract()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $mapper = $this->getMapper();
        $return = $mapper->prepareData('foo', 'catalog_product');
    }

    public function testQueryOne()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $this->insertProduct();
        $mapper = $this->getMapper();
        $select = new Select($mapper->getTableName());
        $select->where(array('name' => 'product'));
        $result = $mapper->queryOne($select);
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
        $this->assertTrue($result instanceof \Zend\Paginator\Paginator);
    }

    public function testSetPaginatorOptions()
    {
        $mapper = $this->getMapper();
        $options = array('p' => 1, 'n' => 10);
        $mapper->setPaginatorOptions($options);
        $return = $mapper->getPaginatorOptions();
        $this->assertSame($options, $return);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetEntityPrototypeThrowsExceptionWhenRelationalModelPropertyIsNull()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $mapper = $this->getMapper();
        $mapper->setRelationalModel(null);
        $mapper->getEntityPrototype();
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetDbModelThrowsExceptionWhenRelationalDbModelPropertyIsNull()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
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

    // NOTE: End of tests

    public function getTestProductModel()
    {
        $product = new \SpeckCatalog\Model\Product();
        $product->setName('product')
            ->setManufacturerId(1);
        return $product;
    }

    public function getMapper()
    {
        $mapper =  $this->getServiceManager()->get('speckcatalog_product_mapper');
        return $mapper;
    }
}
