<?php

namespace SpeckCatalogTest\Mapper;

class ChoiceTest extends AbstractTestCase
{
    public function testFindReturnsChoiceModel()
    {
    }

    public function getByOptionIdReturnsArrayOfChoiceModels()
    {
    }

    public function testInsertReturnsChoiceModel()
    {
    }

    public function testSortOptionsChangesOrderOfOptions()
    {
    }

    public function testAddOptionCreatesLinker()
    {
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_choice_mapper');
    }
}
