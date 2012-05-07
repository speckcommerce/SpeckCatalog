<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Uom, 
    ArrayObject;

class UomMapper extends ModelMapperAbstract
{
    public function getModel($constructor = null)
    {
        return new Uom($constructor);
    }

    public function getIdField()
    {
        return 'uom_code';
    }

    //overrides abstract , where enabled = 1
    public function getAll()
    {
        $select = $this->newSelect();
        $select->where('enabled = ?', 1);
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->select($select);

        return $this->rowsetToModels($rowset);    
    }
}
