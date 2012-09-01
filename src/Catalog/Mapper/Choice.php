<?php

namespace Catalog\Mapper;

class Choice extends AbstractMapper
{
    protected $tableName = 'catalog_choice';
    protected $entityPrototype = '\Catalog\Entity\Choice';
    protected $hydrator = 'Catalog\Hydrator\Choice';

    public function find($choiceId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('choice_id' => (int) $choiceId));
        return $this->selectOne($select);
    }

    public function getByOptionId($optionId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('option_id' => (int) $optionId));
        return $this->selectMany($select);
    }

    public function persist($choice)
    {
        if (null === $choice->getChoiceId()) {
            $id = $this->insert($choice);
            return $choice->setChoiceId($id);
        } else {
            $where = array('choice_id' => $choice->getChoiceId());
            return $this->update($choice, $where);
        }
    }

    public function addOption($choiceId, $optionId)
    {
        $table = 'catalog_choice_option_linker';
        $row = array('choice_id' => $choiceId, 'option_id' => $optionId);
        $select = $this->select()
            ->from($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }
}
