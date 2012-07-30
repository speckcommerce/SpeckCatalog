<?php

namespace Catalog\Model\Mapper;
use Catalog\Model\Choice,
    ArrayObject;

class ChoiceMapper extends ModelMapperAbstract
{
    protected $primaryKey = 'choice_id';
    protected $childOptionLinkerTableName = 'catalog_choice_option_linker';
    protected $parentOptionLinkerTableName = 'catalog_option_choice_linker';
    protected $tableName = 'catalog_choice';

    public function __construct()
    {
        $unsetKeys = array('product', 'target_uom', 'na_choices', 'options', 'parent_options', 'linker_id', 'sort_weight');
        parent::__construct($unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new Choice($constructor);
    }

    public function getChoicesByParentOptionId($optionId)
    {
        $linkerName = $this->parentOptionLinkerTableName;
        $select = $this->select()->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.choice_id = ' . $linkerName . '.choice_id')
            ->where(array('option_id' => $optionId));
        //->order('sort_weight DESC');

        return $this->selectMany($select);
    }

    public function getChoicesByChildProductId($productId)
    {
        $select = $this->select()->from($this->getTableName())
            ->where(array('product_id' => $productId));
        return $this->selectWith($select);
    }

    public function linkParentOption($optionId, $choiceId)
    {
        $row = array(
            'choice_id' => $choiceId,
            'option_id' => $optionId,
        );
        return $this->add($row, $this->parentOptionLinkerTableName);
    }

    public function getChoicesByChildOptionId($optionId)
    {
        $linkerName = $this->childOptionLinkerTableName;
        $select = $this->select()->from($this->tableName)
            ->join($linkerName, $this->tableName . '.choice_id = ' . $linkerName . '.choice_id')
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

}
