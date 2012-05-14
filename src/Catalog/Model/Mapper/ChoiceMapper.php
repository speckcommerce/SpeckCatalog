<?php

namespace Catalog\Model\Mapper;
use Catalog\Model\Choice,
    ArrayObject;

class ChoiceMapper extends ModelMapperAbstract
{
    protected $parentOptionLinkerTable;
    protected $childOptionLinkerTable;
    
    public function getModel($constructor = null)
    {
        return new Choice($constructor);
    }

    public function getChoicesByParentOptionId($optionId)
    {
        $linkerName = $this->getParentOptionLinkerTable()->getTableName();
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.record_id = ' . $linkerName . '.choice_id')
            ->where(array('option_id' => $optionId));
        //->order('sort_weight DESC');
        return $this->selectMany($select);
    }

    public function getChoicesByChildProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTable()->getTableName())
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }

    public function linkParentOption($optionId, $choiceId)
    {
        $table = $this->getParentOptionLinkerTable();
        $row = array(
            'choice_id' => $choiceId,
            'option_id' => $optionId,
        );
        return $this->insertLinker($table, $row); 
    }
    public function getChoicesByChildOptionId($optionId)
    {
        $linkerName = $this->getChildOptionLinkerTable()->getTableName();
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.record_id = ' . $linkerName . '.choice_id')
            ->where(array('option_id' => $optionId));
            //->order('sort_weight DESC');
        return $this->selectMany($select);
    }

    public function updateOptionChoiceSortOrder($order)
    {
        return $this->updateSort('catalog_option_choice_linker', $order);
    }   

    public function removeLinker($linkerId)
    {
        return $this->deleteLinker('catalog_option_choice_linker', $linkerId);
    }     

    public function getParentOptionLinkerTable()
    {
        return $this->parentOptionLinkerTable;
    }

    public function setParentOptionLinkerTable($parentOptionLinkerTable)
    {
        $this->parentOptionLinkerTable = $parentOptionLinkerTable;
        return $this;
    }

    public function getChildOptionLinkerTable()
    {
        return $this->childOptionLinkerTable;
    }

    public function setChildOptionLinkerTable($childOptionLinkerTable)
    {
        $this->childOptionLinkerTable = $childOptionLinkerTable;
        return $this;
    }
}
