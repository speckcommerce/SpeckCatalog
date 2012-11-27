<?php

namespace Catalog\Mapper;

interface DbAdapterAwareInterface
{
    public function getDbAdapter();
    public function setDbAdapter(\Zend\Db\Adapter\Adapter $dbAdapter);
}
