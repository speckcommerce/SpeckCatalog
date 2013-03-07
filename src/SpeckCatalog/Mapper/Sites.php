<?php

namespace SpeckCatalog\Mapper;

class Sites extends AbstractMapper
{
    protected $tableName = 'website';
    protected $model = '\SpeckCatalog\Model\Site';
    protected $tableKeyFields = array('website_id');
}
