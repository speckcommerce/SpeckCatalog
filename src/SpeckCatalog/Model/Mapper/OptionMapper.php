<?php

namespace SpeckCatalog\Model\Mapper;
use SpeckCatalog\Model\Option,
    ArrayObject; 

class OptionMapper extends DbMapperAbstract
{
    protected $modelClass = 'Option';
    protected $tableName = 'catalog_option';
    protected $productLinkerTableName = 'catalog_product_option_linker';
    protected $choiceLinkerTableName = 'catalog_choice_option_linker';

    public function getOptionsByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->join($this->getProductLinkerTableName(), $this->getProductLinkerTableName().'.option_id = '.$this->getTableName().'.option_id') 
            ->where( $this->getProductLinkerTableName().'.product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $options = array();
            foreach($rows as $row){
                $options[] = $this->instantiateModel($row);
            }
            return $options;
        }else{
            return array();
        }
    }

    public function getOptionsByChoiceId($choiceId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->join($this->getChoiceLinkerTableName(), $this->getChoiceLinkerTableName().'.option_id = '.$this->getTableName().'.option_id') 
            ->where( $this->getChoiceLinkerTableName().'.choice_id = ?', $choiceId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $options = array();
            foreach($rows as $row){
                $options[] = $this->instantiateModel($row);
            }
            return $options;
        }else{
            return array();
        }
    }  

    public function instantiateModel($row){
        $option = new Option();
        $option->setOptionId($row['option_id'])
               ->setInstruction($row['instruction'])
               ->setName($row['name'])
               ->setListType($row['list_type']);
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $option));
        return $option;
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
    }

    //public function linkOptionsToProduct($productId, $options)
    //{
    //    foreach($options as $option){
    //        if($option->getOptionId()){
    //            $this->optionMapper->update($option);
    //            $this->linkOptionToProduct($productId, $option->getOptionId());
    //        }else{
    //            $option = $this->optionMapper->add($option);
    //            $this->linkOptionToProduct($productId, $option->getOptionId());
    //        }
    //    }
    //}

    public function getChoiceLinkerTableName(){
        return $this->choiceLinkerTableName;
    }
    public function getProductLinkerTableName(){
        return $this->productLinkerTableName;
    }
}
