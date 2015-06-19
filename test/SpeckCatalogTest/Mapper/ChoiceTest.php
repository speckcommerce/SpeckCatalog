<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class ChoiceTest extends AbstractTestCase
{
    public function testFindReturnsChoiceModel()
    {
        $choiceId = $this->insertChoice(1);
        $mapper = $this->getMapper();
        $result = $mapper->find(array('choice_id' => $choiceId));
        $this->assertTrue($result instanceof \SpeckCatalog\Model\Choice);
    }

    public function testGetByOptionIdReturnsArrayOfChoiceModels()
    {
        $this->insertChoice(1);
        $mapper = $this->getMapper();
        $result = $mapper->getByOptionId(1);
        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof \SpeckCatalog\Model\Choice);
    }

    public function testInsertReturnsChoiceModel()
    {
        $choice = new \SpeckCatalog\Model\Choice();
        $mapper = $this->getMapper();
        $result = $mapper->insert($choice);
        $this->assertTrue($result instanceof \SpeckCatalog\Model\Choice);
    }

    public function testSortOptionsChangesOrderOfOptions()
    {
        $linker1 = array('choice_id' => 1, 'option_id' => 3, 'sort_weight' => 0);
        $linker2 = array('choice_id' => 1, 'option_id' => 4, 'sort_weight' => 1);
        $testMapper = $this->getTestMapper();
        $testMapper->insert($linker1, 'catalog_choice_option');
        $testMapper->insert($linker2, 'catalog_choice_option');

        $order = array(4,3);
        $mapper = $this->getMapper();
        $mapper->sortOptions(1, $order);

        $select = new \Zend\Db\Sql\Select('catalog_choice_option');
        $select->where(array('choice_id' => 1, 'sort_weight' => 0));
        $result = $testMapper->query($select);

        $this->assertTrue(is_array($result) && $result['option_id'] == 4);
    }

    public function testAddOptionCreatesLinker()
    {
        $choiceId = $this->insertChoice(1);
        $optionId = $this->insertOption();
        $mapper = $this->getMapper();
        $mapper->addOption($choiceId, $optionId);

        $select = new \Zend\Db\Sql\Select('catalog_choice_option');
        $select->where(array('option_id' => $optionId, 'choice_id' => $choiceId));
        $testMapper = $this->getTestMapper();
        $result = $testMapper->query($select);

        $this->assertTrue(is_array($result));
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_choice_mapper');
    }
}
