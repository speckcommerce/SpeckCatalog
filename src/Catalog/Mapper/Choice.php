<?php

namespace Catalog\Mapper;

class Choice extends AbstractMapper
{
    protected $tableName = 'catalog_choice';
    protected $relationalModel = '\Catalog\Model\Choice\Relational';
    protected $dbModel = '\Catalog\Model\Choice';
    protected $key = array('choice_id');

    public function find(array $data)
    {
        $select = $this->getSelect()
            ->from($this->getTableName())
            ->where(array('choice_id' => (int) $data['choice_id']));
        return $this->selectOne($select);
    }

    public function getByOptionId($optionId)
    {
        $select = $this->getSelect()
            ->from($this->getTableName())
            ->where(array('option_id' => (int) $optionId));
        return $this->selectMany($select);
    }

    public function persist($choice)
    {
        $dbChoice = $this->getDbModel($choice);
        if (null === $choice->getChoiceId()) {
            $id = $this->insert($dbChoice);
            $choice->setChoiceId($id);
            return $choice;
        } else {
            $where = array('choice_id' => $choice->getChoiceId());
            return $this->update($choice, $where);
        }
    }

    public function addOption($choiceId, $optionId)
    {
        $table = 'catalog_choice_option';
        $row = array('choice_id' => $choiceId, 'option_id' => $optionId);
        $select = $this->getSelect()
            ->from($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }
}
