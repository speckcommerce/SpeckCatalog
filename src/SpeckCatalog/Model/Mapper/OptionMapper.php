<?php

namespace SpeckCatalog\Model\Mapper;
use SpeckCatalog\Model\Option; 

class OptionMapper extends DbMapperAbstract
{
    protected $modelClass = 'option';
    protected $tableName = 'catalog_option';
    protected $linkerTableName = 'catalog_product_option_linker';

    public function getOptionsByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->join($this->getLinkerTableName(), $this->getLinkerTableName().'.option_id = '.$this->getTableName().'.option_id') 
            ->where( $this->getLinkerTableName().'.product_id = ?', $productId);
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
               ->setName($row['name']);
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $option));
        return $option;
    }

    public function linkOptionToProduct($productId, $optionId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getLinkerTableName())
            ->where('product_id = ?', $productId)
            ->where('option_id = ?', $optionId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'product_id' => $productId,
                'option_id'  => $optionId,
            ));
            $db->insert($this->getLinkerTableName(), (array) $data);
        }
    }

    public function linkOptionsToProduct($productId, $options)
    {
        foreach($options as $option){
            if($option->getOptionId()){
                $this->optionMapper->update($option);
                $this->linkOptionToProduct($productId, $option->getOptionId());
            }else{
                $option = $this->optionMapper->add($option);
                $this->linkOptionToProduct($productId, $option->getOptionId());
            }
        }
    }

    public function getLinkerTableName(){
        return $this->linkerTableName;
    }
}
