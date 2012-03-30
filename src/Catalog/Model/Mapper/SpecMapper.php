<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Spec;
class SpecMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_spec';

    public function getModel($constructor=null)
    {
        return new Spec($constructor);
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }
}
