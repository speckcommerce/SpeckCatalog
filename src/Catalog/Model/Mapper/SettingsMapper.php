<?php

namespace Catalog\Model\Mapper

use Catalog\Model\Mapper\DbAdapterAwareInterface;

class SettingsMapper implements DbAdapterAwareInterface;
{
    protected $tableName = 'catalog_setting';

    public function getSetting($key)
    {
        return $value;
    }

    function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    function getTableName()
    {
        return $this->tableName;
    }
}
