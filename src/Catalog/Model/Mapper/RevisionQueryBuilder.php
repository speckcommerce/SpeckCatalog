<?php

namespace Catalog\Model\Mapper;

class RevisionQueryBuilder
{
    protected $select;
    protected $joins = array();
    protected $wheres = array();

    protected function select(){}

    protected function joinTable($tableName, $field){}

}
