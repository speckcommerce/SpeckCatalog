<?php

namespace Catalog\Mapper;

class Option extends AbstractMapper
{
    protected $tableName = 'catalog_option';
    protected $entityPrototype = '\Catalog\Entity\Option';
    protected $hydrator = 'Catalog\Hydrator\Option';

    public function find($optionId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('option_id' => (int) $optionId));
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $linker = 'catalog_product_option_linker';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->select()
            ->from($table)
            ->join($linker, $joinString)
            ->where(array('product_id' => (int) $productId));
        return $this->selectMany($select);
    }

    public function getByParentChoiceId($choiceId)
    {
        $linker = 'catalog_choice_option_linker';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->select()
            ->from($table)
            ->join($linker, $joinString)
            ->where(array($linker . '.choice_id' => (int) $choiceId));
        return $this->selectMany($select);
    }

    public function persist($option)
    {
        if(null === $option->getOptionId()) {
            $id = $this->insert($option);
            return $this->find($id);
        }
        $existing = self::find($option->getOptionId());
        if($existing){
            $where = array('option_id' => $option->getOptionId());
            return $this->update($option, $where);
        } else {
            $id = $this->insert($option);
            return $this->find($id);
        }
    }
}
