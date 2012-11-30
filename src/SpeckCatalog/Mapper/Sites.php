<?php

namespace SpeckCatalog\Mapper;

class Sites extends AbstractMapper
{
    protected $tableName = 'website';
    protected $dbModel = '\SpeckCatalog\Model\Site';
    protected $relationalModel = '\SpeckCatalog\Model\Site';
    protected $key = array('website_id');
}
