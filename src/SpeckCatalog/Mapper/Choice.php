<?php

namespace SpeckCatalog\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class Choice extends AbstractMapper
{
    protected $tableName = 'catalog_choice';
    protected $relationalModel = '\SpeckCatalog\Model\Choice\Relational';
    protected $dbModel = '\SpeckCatalog\Model\Choice';
    protected $key = array('choice_id');
    protected $dbFields = array('choice_id', 'product_id', 'option_id', 'price_override_fixed', 'price_discount_percent', 'price_no_charge', 'override_name', 'sort_weight');

    public function find(array $data)
    {
        $select = $this->getSelect()
            ->where(array('choice_id' => (int) $data['choice_id']));
        return $this->selectOne($select);
    }

    public function getByOptionId($optionId)
    {
        $select = $this->getSelect()
            ->where(array('option_id' => (int) $optionId))
            ->order('sort_weight', 'ASC');
        return $this->selectMany($select);
    }

    public function insert($choice, $tableName=null, HydratorInterface $hydrator=null)
    {
        $choiceId = parent::insert($choice, $tableName, $hydrator);
        return $this->find(array('choice_id' => $choiceId));
    }

    public function sortOptions($choiceId, $order)
    {
        $table = 'catalog_choice_option';
        foreach ($order as $i => $optionId) {
            $where = array('choice_id' => $choiceId, 'option_id' => $optionId);
            $select = $this->getSelect($table)->where($where);
            $row = $this->query($select);
            $row['sort_weight'] = $i;
            $this->update($row, $where, $table);
        }
    }

    public function addOption($choiceId, $optionId)
    {
        $table = 'catalog_choice_option';
        $row = array('choice_id' => $choiceId, 'option_id' => $optionId);
        $select = $this->getSelect($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }
}
