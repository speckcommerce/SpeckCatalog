<?php
namespace Catalog\Model\Mapper;
use Zend\Db\TableGateway\TableGateway as ZfTableGateway;
class TableGateway extends ZfTableGateway
{
    public function getTableName()
    {
        if(!$this->getTable()){
            die('fail');
        }
        return (string) $this->getTable();
    }
}
