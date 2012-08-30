<?php

namespace Catalog\Mapper;

class Choice extends AbstractMapper
{
    protected $tableName = 'catalog_choice';
    protected $entityPrototype = '\Catalog\Entity\Choice';
    protected $hydrator = 'Catalog\Hydrator\Choice';

    public function getByOptionId($optionId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('option_id' => (int) $optionId));
        return $this->selectMany($select);
    }
}
