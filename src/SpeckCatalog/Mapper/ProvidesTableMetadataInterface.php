<?php

namespace SpeckCatalog\Mapper;

interface ProvidesTableMetadataInterface
{
    public function getTableFields();
    public function getTableName();
    public function getTableKeyFields();
}
