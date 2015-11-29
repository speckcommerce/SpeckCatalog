<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class OptionTest extends AbstractTestCase
{
    public function testGetBuildersByProductIdReturnsChoiceRows()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $testMapper = $this->getTestMapper();
        $testMapper->insert(
            ['product_id' => 1, 'option_id' => 1],
            'catalog_product_option'
        );
        $testMapper->insert(
            ['option_id' => 1, 'builder' => 1, 'required' => 1],
            'catalog_option'
        );
        $testMapper->insert(
            ['option_id' => 1, 'choice_id' => 1, 'product_id' => 2],
            'catalog_builder_product'
        );

        $mapper = $this->getMapper();
        $result = $mapper->getBuildersByProductId(1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0]['choice_id'] == 1);
        $this->assertTrue($result[0]['product_id'] == 2);
    }

    public function testInsertReturnsOptionModel()
    {
        $mapper = $this->getMapper();
        $option = ['name' => 'option'];
        $option = $mapper->insert($option);
        $this->assertTrue($option instanceof \SpeckCatalog\Model\Option);
    }

    public function testFindReturnsOptionModel()
    {
        $optionId = $this->insertOption();
        $mapper = $this->getMapper();
        $result = $mapper->find(['option_id' => $optionId]);

        $this->assertTrue($result instanceof \SpeckCatalog\Model\Option);
    }

    public function testGetByProductIdReturnsArrayOfOptionModels()
    {
        $optionId = $this->insertOption();
        $linker = ['product_id' => 1, 'option_id' => $optionId];
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_product_option');

        $mapper = $this->getMapper();
        $result = $mapper->getByProductId(1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof \SpeckCatalog\Model\Option);
    }

    public function testGetByParentChoiceIdReturnsArrayOfOptionModels()
    {
        $optionId = $this->insertOption();
        $linker = ['option_id' => $optionId, 'choice_id' => 1];
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_choice_option');

        $mapper = $this->getMapper();
        $result = $mapper->getByParentChoiceId(1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof \SpeckCatalog\Model\Option);
    }

    public function testSortChoicesChangesOrderOfChoices()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $optionId = 1;
        $choice1 = ['option_id' => $optionId, 'sort_weight' => 0];
        $choice2 = ['option_id' => $optionId, 'sort_weight' => 1];
        $testMapper = $this->getTestMapper();
        $choiceId1 = $testMapper->insert($choice1, 'catalog_choice')->getGeneratedValue();
        $choiceId2 = $testMapper->insert($choice2, 'catalog_choice')->getGeneratedValue();

        $order = [$choiceId2, $choiceId1];
        $mapper = $this->getMapper();
        $mapper->sortChoices($optionId, $order);

        $select = new \Zend\Db\Sql\Select('catalog_choice');
        $select->where(['choice_id' => $choiceId2]);
        $result = $testMapper->query($select);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result['sort_weight'] == 0);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_option_mapper');
    }
}
