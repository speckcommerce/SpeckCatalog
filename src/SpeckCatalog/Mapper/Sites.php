<?php

namespace Catalog\Mapper;

class Sites extends AbstractMapper
{
    protected $tableName = 'website';
    protected $dbModel = '\Catalog\Model\Site';
    protected $relationalModel = '\Catalog\Model\Site';
    protected $key = array('website_id');
}
