<?php

namespace Catalog\Model\Mapper;
use Catalog\Model\Option,
    ArrayObject;

class OptionMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_option';
    protected $productLinkerTableName = 'catalog_product_option_linker';
    protected $childChoiceLinkerTableName = 'catalog_option_choice_linker';
    protected $parentChoiceLinkerTableName = 'catalog_choice_option_linker';

    public function __construct($adapter)
    {
        $unsetKeys = array('choices', 'parent_choices', 'slider', 'builder_segment', 'images', 'choice_uom_adjustments', 'price_map', 'parent_products');
        parent::__construct($adapter, $unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new Option($constructor);
    }

    public function getOptionsByProductId($productId)
    {
        $select = $this->select()->from($this->tableName)
            ->join($this->productLinkerTableName, $this->tableName . '.record_id = ' . $this->productLinkerTableName . '.option_id')
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }

    public function getOptionsByChoiceId($choiceId)
    {
        $linkerName = $this->parentChoiceLinkerTableName;
        $select = $this->select()->from($this->tableName)
            ->join($linkerName, $this->tableName . '.record_id = ' . $linkerName . '.option_id' )
            ->where(array('choice_id' => $choiceId));
        //->order('sort_weight DESC');
        return $this->selectMany($select);
    }

    public function linkOptionToProduct($productId, $optionId)
    {
        $row = array(
            'product_id' => $productId,
            'option_id' => $optionId,
        );
        return $this->add($row, $this->productLinkerTableName);
    }

    public function linkOptionToChoice($choiceId, $optionId)
    {
        $row = array(
            'choice_id' => $choiceId,
            'option_id' => $optionId,
        );
        return $this->add($row, $this->parentChoiceLinkerTableName);
    }

    public function updateChoiceOptionSortOrder($order)
    {
        return $this->updateSort('catalog_choice_option_linker', $order);
    }

    public function updateProductOptionSortOrder($order)
    {
        return $this->updateSort('catalog_product_option_linker', $order);
    }

    public function getChoiceLinkerTableName(){
        return $this->choiceLinkerTableName;
    }

    public function getProductLinkerTableName(){
        return $this->productLinkerTableName;
    }

    public function removeLinker($linkerId)
    {
        return $this->deleteLinker('catalog_product_option_linker', $linkerId);
    }
}
