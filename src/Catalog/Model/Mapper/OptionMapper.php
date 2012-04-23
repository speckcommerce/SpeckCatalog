<?php

namespace Catalog\Model\Mapper;
use Catalog\Model\Option,
    ArrayObject; 

class OptionMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_option';
    protected $productLinkerTableName = 'catalog_product_option_linker';
    protected $choiceLinkerTableName = 'catalog_choice_option_linker';

    public function getModel($constructor = null)
    {
        return new Option($constructor);
    }

    public function getOptionsByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->join($this->getProductLinkerTableName(), $this->getProductLinkerTableName().'.option_id = '.$this->getTableName().'.option_id') 
            ->where( $this->getProductLinkerTableName().'.product_id = ?', $productId)
            ->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
    }

    public function getOptionsByChoiceId($choiceId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->join($this->getChoiceLinkerTableName(), $this->getChoiceLinkerTableName().'.option_id = '.$this->getTableName().'.option_id') 
            ->where( $this->getChoiceLinkerTableName().'.choice_id = ?', $choiceId)
            ->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
    }  

    public function linkOptionToProduct($productId, $optionId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getProductLinkerTableName())
            ->where('product_id = ?', $productId)
            ->where('option_id = ?', $optionId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'product_id' => $productId,
                'option_id'  => $optionId,
            ));
            $db->insert($this->getProductLinkerTableName(), (array) $data);
        }
        return $db->lastInsertId();
    }
    
    public function linkOptionToChoice($choiceId, $optionId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getChoiceLinkerTableName())
            ->where('choice_id = ?', $choiceId)
            ->where('option_id = ?', $optionId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'choice_id' => $choiceId,
                'option_id'  => $optionId,
            ));
            $db->insert($this->getChoiceLinkerTableName(), (array) $data);
        }
        return $db->lastInsertId();
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
