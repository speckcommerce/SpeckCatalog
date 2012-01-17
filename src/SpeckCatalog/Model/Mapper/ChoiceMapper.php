<?php

namespace SpeckCatalog\Model\Mapper;
use SpeckCatalog\Model\Choice, 
    ArrayObject;

class ChoiceMapper extends DbMapperAbstract
{
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
    
    public function getChoiceById($id)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->where( 'choice_id = ?', $id);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);

        return $this->instantiateModel($row);  
    }

    public function newModel()
    {
        $choice = new Choice;
        return $this->add($choice);
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

    public function add(Choice $choice)
    {
        return $this->persist($choice);
    }

    public function update(Choice $choice)
    {
        return $this->persist($choice, 'update');
    }       

    public function persist(Choice $choice, $mode = 'insert')
    {
        $data = new ArrayObject($choice->toArray());
        $data['search_data'] = $choice->getSearchData();

        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('data' => $data));
        $db = $this->getWriteAdapter();
        if ('update' === $mode) {
            $db->update($this->getTableName(),(array) $data, $db->quoteInto('choice_id = ?', $choice->getChoiceId())); 
        } elseif ('insert' === $mode) {
            $db->insert($this->getTableName(), (array) $data);
            $choice->setChoiceId($db->lastInsertId());
        }
        return $choice;
    }   
}
