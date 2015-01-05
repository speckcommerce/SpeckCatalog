<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class CategoryTest extends AbstractTestCase
{
    public function testFindReturnsCategoryModel()
    {
        $categoryId = $this->insertCategory();

        $mapper = $this->getMapper();
        $return = $mapper->find(array('category_id' => $categoryId));
        $this->assertTrue($return instanceOf \SpeckCatalog\Model\Category);
    }

    public function testGetChildCategoriesReturnsArrayOfCategoryModels()
    {
        $parentId = $this->insertCategory();
        $childId = $this->insertCategory();
        $linker = array(
            'category_id' => $childId,
            'parent_category_id' => $parentId,
            'website_id' => 1,
        );
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_category_website');

        $mapper = $this->getMapper();
        $return = $mapper->getChildCategories($parentId);
        $this->assertTrue(is_array($return));
        $this->assertTrue($return[0] instanceOf \SpeckCatalog\Model\Category);
    }

    public function testGetChildCategoriesWithoutParentCategoryReturnsArrayOfCategoryModels()
    {
        $parentId = null;
        $childId = $this->insertCategory();
        $linker = array(
            'category_id' => $childId,
            'parent_category_id' => $parentId,
            'website_id' => 1,
        );
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_category_website');

        $mapper = $this->getMapper();
        $return = $mapper->getChildCategories($parentId);
        $this->assertTrue(is_array($return));
        $this->assertTrue($return[0] instanceOf \SpeckCatalog\Model\Category);
    }

    public function testGetCrumbsReturnsArrayOfCategoryCrumbs()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $parent = array('name' => 'parent');
        $child = array('name' => 'child');
        $testMapper = $this->getTestMapper();
        $parentId = $testMapper->insert($parent, 'catalog_category')->getGeneratedValue();
        $childId = $testMapper->insert($child, 'catalog_category')->getGeneratedValue();
        $linker = array(
            'category_id' => $childId,
            'parent_category_id' => $parentId,
            'website_id' => 1,
        );
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_category_website');

        $mapper = $this->getMapper();
        $return = $mapper->getCrumbs($childId);
        $this->assertTrue(is_array($return));
        $this->assertEquals('parent,child', implode(',', $return));
    }

    public function testAddProductCreatesLinker()
    {
        $mapper = $this->getMapper();
        $mapper->addProduct(9,6);

        $select = new \Zend\Db\Sql\Select('catalog_category_product');
        $select->where(array('category_id' => 9, 'product_id' => 6));
        $testMapper = $this->getTestMapper();
        $result = $testMapper->query($select);
        $this->assertTrue(is_array($result));
    }

    public function testAddCategoryCreatesLinker()
    {
        $mapper = $this->getMapper();
        $mapper->addCategory(9, 6);

        $select = new \Zend\Db\Sql\Select('catalog_category_website');
        $select->where(array('parent_category_id' => 9, 'category_id' => 6));
        $testMapper = $this->getTestMapper();
        $result = $testMapper->query($select);
        $this->assertTrue(is_array($result));
    }

    public function testAddCategoryAsTopLevelCategoryCreatesLinker()
    {
        $mapper = $this->getMapper();
        $mapper->addCategory(null, 6);

        $select = new \Zend\Db\Sql\Select('catalog_category_website');
        $select->where(array('category_id' => 6));
        $testMapper = $this->getTestMapper();
        $result = $testMapper->query($select);
        $this->assertTrue(is_array($result));
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_category_mapper');
    }
}
