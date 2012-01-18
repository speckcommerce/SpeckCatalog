<?php

namespace SpeckCatalog\Model\Mapper;
use SpeckCatalog\Model\Choice, 
    ArrayObject;

class ChoiceMapper extends DbMapperAbstract
{
    protected $modelClass = 'Choice';
    protected $tableName = 'catalog_choice';

    public function getChoicesByParentOptionId($optionId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('parent_option_id = ?', $optionId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $choices = array();
            foreach($rows as $row){
                $choices[] = $this->instantiateModel($row);
            }
            return $choices;
        }else{
            return array();
        }
    }
    
    public function instantiateModel($row){
        $choice = new Choice;
        $choice->setChoiceId($row['choice_id'])
               ->setProductId($row['product_id'])
               ->setParentOptionId($row['parent_option_id'])
               ->setOverrideName($row['override_name']);
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $choice));
        return $choice;
    }


}
