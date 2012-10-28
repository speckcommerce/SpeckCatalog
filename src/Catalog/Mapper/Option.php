<?php

namespace Catalog\Mapper;

class Option extends AbstractMapper
{
    protected $tableName = 'catalog_option';
    protected $dbModel = '\Catalog\Model\Option';
    protected $relationalModel = '\Catalog\Model\Option\Relational';
    protected $hydrator = 'Catalog\Hydrator\Option';
    protected $key = array('option_id');

    public function find(array $data)
    {
        $select = $this->getSelect()
            ->where(array('option_id' => $data['option_id']));
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $linker = 'catalog_product_option';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->getSelect($table)
            ->join($linker, $joinString)
            ->where(array('product_id' => (int) $productId));
        return $this->selectMany($select);
    }

    public function getByParentChoiceId($choiceId)
    {
        $linker = 'catalog_choice_option';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->getSelect($table)
            ->join($linker, $joinString)
            ->where(array($linker . '.choice_id' => (int) $choiceId));
        return $this->selectMany($select);
    }

    public function persist($option)
    {
        $option = $this->getDbModel($option);
        if(null === $option->getOptionId()) {
            $id = $this->insert($option);
            return $this->find(array('option_id' => $id));
        }
        $existing = self::find(array('option_id' => $option->getOptionId()));
        if($existing){
            $where = array('option_id' => $option->getOptionId());
            return $this->update($option, $where);
        } else {
            $id = $this->insert($option);
            return $this->find(array('option_id' => $id));
        }
    }
}
