<?php
namespace Catalog\Model\Mapper;
use Zend\Db\TableGateway\TableGateway as ZfTableGateway;
class TableGateway extends ZfTableGateway
{
    public function getTableName()
    {
        return (string) $this->getTable();
    }
}
