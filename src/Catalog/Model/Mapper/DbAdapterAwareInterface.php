<?php

namespace Catalog\Model\Mapper;

use Zend\Db\Adapter\Adapter;

interface DbAdapterAwareInterface
{
    public function getDbAdapter();
    public function setDbAdapter(Adapter $adapter);
}
