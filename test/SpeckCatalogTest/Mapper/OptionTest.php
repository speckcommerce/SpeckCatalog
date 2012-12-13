<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\Asset\AbstractTestCase;

class OptionTest extends AbstractTestCase
{
    public function testInsertReturnsOptionModel()
    {
        $mapper = $this->getMapper();
        $option = array('name' => 'option');
        $option = $mapper->insert($option);
        $this->assertTrue($option instanceOf \SpeckCatalog\Model\Option);
    }

    public function testFindReturnsOptionModel()
    {
        $optionId = $this->insertOption();
        $mapper = $this->getMapper();
        $result = $mapper->find(array('option_id' => $optionId));

        $this->assertTrue($result instanceOf \SpeckCatalog\Model\Option);
    }

    public function testGetByProductIdReturnsArrayOfOptionModels()
    {
        $optionId = $this->insertOption();
        $linker = array('product_id' => 1, 'option_id' => $optionId);
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_product_option');

        $mapper = $this->getMapper();
        $result = $mapper->getByProductId(1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceOf \SpeckCatalog\Model\Option);
    }

    public function testGetByParentChoiceIdReturnsArrayOfOptionModels()
    {
        $optionId = $this->insertOption();
        $linker = array('option_id' => $optionId, 'choice_id' => 1);
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker, 'catalog_choice_option');

        $mapper = $this->getMapper();
        $result = $mapper->getByParentChoiceId(1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceOf \SpeckCatalog\Model\Option);
    }

    public function testSortChoicesChangesOrderOfChoices()
    {
        $optionId = 1;
        $choice1 = array('option_id' => $optionId, 'sort_weight' => 0);
        $choice2 = array('option_id' => $optionId, 'sort_weight' => 1);
        $testMapper = $this->getTestMapper();
        $choiceId1 = $testMapper->insert($choice1, 'catalog_choice')->getGeneratedValue();
        $choiceId2 = $testMapper->insert($choice2, 'catalog_choice')->getGeneratedValue();

        $order = array($choiceId2, $choiceId1);
        $mapper = $this->getMapper();
        $mapper->sortChoices($optionId, $order);

        $select = new \Zend\Db\Sql\Select('catalog_choice');
        $select->where(array('choice_id' => $choiceId2));
        $result = $testMapper->query($select);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result['sort_weight'] == 0);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_option_mapper');
    }
}
