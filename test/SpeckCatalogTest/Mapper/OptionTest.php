<?php

namespace SpeckCatalogTest;

use PHPUnit\Extensions\Database\TestCase;

class OptionTest extends \PHPUnit_Framework_TestCase
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
        $mapper = $this->getMapper();
        $mapper->insert($linker, 'catalog_product_option');
        $result = $mapper->getByProductId(1);

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceOf \SpeckCatalog\Model\Option);
    }

    public function testGetByParentChoiceIdReturnsArrayOfOptionModels()
    {
        $optionId = $this->insertOption();
        $linker = array('option_id' => $optionId, 'choice_id' => 1);
        $mapper = $this->getMapper();
        $mapper->insert($linker, 'catalog_choice_option');
        $result = $mapper->getByParentChoiceId(1);

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceOf \SpeckCatalog\Model\Option);
    }

    public function testSortChoicesChangesOrderOfChoices()
    {
        $optionId = 1;
        $choice1 = array('option_id' => $optionId, 'sort_weight' => 0);
        $choice2 = array('option_id' => $optionId, 'sort_weight' => 1);
        $mapper = $this->getServiceManager()->get('speckcatalog_choice_mapper');
        $choice1 = $mapper->insert($choice1);
        $choice2 = $mapper->insert($choice2);

        $order = array($choice2->getChoiceId(), $choice1->getChoiceId());
        $mapper = $this->getMapper();
        $mapper->sortChoices($optionId, $order);

        $select = new \Zend\Db\Sql\Select('catalog_choice');
        $select->where(array('choice_id' => $choice2->getChoiceId()));
        $result = $mapper->query($select);

        $this->assertTrue(is_array($result));

        $this->assertTrue($result['sort_weight'] == 0);
    }

    public function getMapper()
    {
        $mapper =  $this->getServiceManager()->get('speckcatalog_option_mapper');
        return $mapper;
    }

    public function getServiceManager()
    {
        return \SpeckCatalogTest\Bootstrap::getServiceManager();
    }

    public function insertOption()
    {
        $mapper = $this->getMapper();
        $option = array('name' => 'option');
        $option = $mapper->insert($option);
        return $option->getOptionId();
    }

    public function setup()
    {
        $db = $this->getServiceManager()->get('speckcatalog_db');
        $query = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_option`(
    `option_id`       INTEGER PRIMARY KEY AUTOINCREMENT,
    `name`            VARCHAR(255),
    `instruction`     VARCHAR(255),
    `required`        INTEGER(1),
    `variation`       INTEGER(1),
    `option_type_id`  INTEGER(1)
);
sqlite;
        $db->query($query)->execute();

        $query = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product_option`(
    `product_id`      INTEGER(11),
    `option_id`       INTEGER(11),
    `sort_weight`     INTEGER(11)
);
sqlite;
        $db->query($query)->execute();

        $query = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_choice_option`(
    `option_id`       INTEGER(11),
    `choice_id`       INTEGER(11),
    `sort_weight`     INTEGER(11)
);
sqlite;
        $db->query($query)->execute();

        $query = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_choice` (
  `choice_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `product_id` INTEGER(11),
  `option_id` INTEGER(11),
  `price_override_fixed` DECIMAL(15,5) NOT NULL DEFAULT '0.00000',
  `price_discount_fixed` DECIMAL(15,5) NOT NULL DEFAULT '0.00000',
  `price_discount_percent` DECIMAL(5,2) NOT NULL DEFAULT '0.00',
  `price_no_charge` INTEGER(1) NOT NULL DEFAULT '0',
  `override_name` VARCHAR(255) DEFAULT NULL,
  `sort_weight` INTEGER(11) NOT NULL DEFAULT '0'
);
sqlite;
        $db->query($query)->execute();
    }
}
