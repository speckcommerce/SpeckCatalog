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
                $choices[] = $this->mapModel($row);
            }
            return $choices;
        }else{
            return array();
        }
    }
}
