<?php

namespace SpeckCatalog\Mapper;

use SpeckCatalog\Model\AbstractModel;
use Zend\Stdlib\Hydrator\HydratorInterface;

class Option extends AbstractMapper
{
    protected $tableName = 'catalog_option';
    protected $dbModel = '\SpeckCatalog\Model\Option';
    protected $relationalModel = '\SpeckCatalog\Model\Option\Relational';
    protected $key = array('option_id');
    protected $dbFields = array('option_id', 'name', 'instruction', 'required', 'variation', 'option_type_id');

    public function find(array $data)
    {
        $where = array('option_id' => $data['option_id']);
        return parent::find($where);
    }

    public function getByProductId($productId)
    {
        $linker = 'catalog_product_option';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->getSelect()
            ->join($linker, $joinString)
            ->where(array('product_id' => (int) $productId))
            ->order('sort_weight', 'ASC');
        return $this->selectMany($select);
    }

    public function getByParentChoiceId($choiceId)
    {
        $linker = 'catalog_choice_option';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->getSelect()
            ->join($linker, $joinString)
            ->where(array($linker . '.choice_id' => (int) $choiceId))
            ->order('sort_weight', 'ASC');
        return $this->selectMany($select);
    }

    public function sortChoices($optionId, $order)
    {
        $table = 'catalog_choice';
        foreach ($order as $i => $choiceId) {
            $where = array('option_id' => $optionId, 'choice_id' => $choiceId);
            $select = $this->getSelect($table)->where($where);
            $row = $this->query($select);
            $row['sort_weight'] = $i;
            $this->update($row, $where, $table);
        }
    }

    public function insert($option, $tableName=null, HydratorInterface $hydrator=null)
    {
        $optionId = parent::insert($option, $tableName, $hydrator);
        $option = $this->find(array('option_id' => $optionId));

        return $option;
    }
}
