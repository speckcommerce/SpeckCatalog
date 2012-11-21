<?php

namespace Catalog\Mapper;

use Catalog\Model\AbstractModel;
use Zend\Stdlib\Hydrator\HydratorInterface;

class Option extends AbstractMapper
{
    protected $tableName = 'catalog_option';
    protected $dbModel = '\Catalog\Model\Option';
    protected $relationalModel = '\Catalog\Model\Option\Relational';
    protected $key = array('option_id');

    public function find(array $data)
    {
        $select = $this->getSelect()
            ->where(array('option_id' => $data['option_id']));
        $option = $this->selectOne($select);
        return $this->selectOne($select);
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
            ->where(array($linker . '.choice_id' => (int) $choiceId));
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
        $optionId = parent::insert($option);
        $option = $this->find(array('option_id' => $optionId));

        return $option;
    }
}
