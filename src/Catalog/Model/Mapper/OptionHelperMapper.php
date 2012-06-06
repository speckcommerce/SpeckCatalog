<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Availability, 
    ArrayObject;

class OptionHelperMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_option_helper';

    public function getHelpers($helperName, $optionId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->where('option_id = ?', $optionId)
            ->where('helper_name = ?', $helperName);
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
}
