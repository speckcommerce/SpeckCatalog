<?php

namespace Catalog\Model\Mapper;
use Catalog\Model\Choice, 
    ArrayObject;

class ChoiceMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_choice';

    public function getModel($constructor = null)
    {
        return new Choice($constructor);
    }

    public function getChoicesByParentOptionId($optionId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->join('catalog_option_choice_linker', 'catalog_option_choice_linker'.'.choice_id = '.$this->getTableName().'.choice_id') 
                  ->where('option_id = ?', $optionId);
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

    public function linkParentOption($optionId, $choiceId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from('catalog_option_choice_linker')
            ->where('option_id = ?', $optionId)
            ->where('choice_id = ?', $choiceId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'option_id'  => $optionId,
                'choice_id' => $choiceId,
            ));
            $result = $db->insert('catalog_option_choice_linker', (array) $data);
            if($result !== 1){
                var_dump($result);
                die('something didnt work!');
            }
            
        }
    }   
}
