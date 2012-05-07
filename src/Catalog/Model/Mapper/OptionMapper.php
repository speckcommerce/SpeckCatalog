<?php

namespace Catalog\Model\Mapper;
use Catalog\Model\Option,
    ArrayObject; 

class OptionMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_option';
    protected $parentProductLinkerTable;
    protected $parentChoiceLinkerTable;
    protected $productLinkerTableName = 'catalog_product_option_linker';
    protected $choiceLinkerTableName = 'catalog_choice_option_linker';

    public function getModel($constructor = null)
    {
        return new Option($constructor);
    }

    public function getOptionsByProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join('catalog_product_option_linker', $this->getTableName() . '.option_id = catalog_product_option_linker.option_id')
            ->where(array('product_id' => $productId));
            //->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);     
    }    
                       
    public function getOptionsByChoiceId($choiceId)
    {
        $linkerName = $this->getParentChoiceLinkerTable()->getTableName();
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.' . $this->getIdField() . ' = ' . $linkerName . '.' . $this->getIdField())
            ->where(array('choice_id' => $choiceId));
        //->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);  
    }  

    public function linkOptionToProduct($productId, $optionId)
    {
        $table = $this->getParentProductLinkerTable();
        $row = array(
            'product_id' => $productId,
            'option_id' => $optionId,
        );
        return $this->insertLinker($table, $row);
    }
    
    public function linkOptionToChoice($choiceId, $optionId)
    {
        $table = $this->getParentChoiceLinkerTable();
        $row = array(
            'choice_id' => $choiceId,
            'option_id' => $optionId,
        );
        return $this->insertLinker($table, $row);    
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
 
    public function getParentProductLinkerTable()
    {
        return $this->parentProductLinkerTable;
    }
 
    public function setParentProductLinkerTable($parentProductLinkerTable)
    {
        $this->parentProductLinkerTable = $parentProductLinkerTable;
        return $this;
    }
 
    public function getParentChoiceLinkerTable()
    {
        return $this->parentChoiceLinkerTable;
    }
 
    public function setParentChoiceLinkerTable($parentChoiceLinkerTable)
    {
        $this->parentChoiceLinkerTable = $parentChoiceLinkerTable;
        return $this;
    }
}
