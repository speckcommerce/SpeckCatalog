<?php

namespace SpeckCatalog\Mapper;

trait ProvidesTableMetadataTrait
{
    public function getTableFields()
    {
        return $this->tableFields;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getTableKeyFields(array $removeFields = array())
    {
        $fields = $this->tableKeyFields;
        if (count($removeFields)) {
            return array_diff($fields, $removeFields);
        }
        return $fields;
    }
}
