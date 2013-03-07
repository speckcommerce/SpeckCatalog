<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class CompanyTest extends AbstractTestCase
{
    public function testFindByIdReturnsCompanyModel()
    {
        $testMapper = $this->getTestMapper();
        $testMapper->insert(array('company_id' => 1, 'name' => 'company'), 'contact_company');

        $mapper = $this->getMapper();
        $result = $mapper->findById(1);
        $this->assertTrue($result instanceOf \SpeckCatalog\Model\Company);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_company_mapper');
    }

    public function testGetAllReturnsArrayOfCompanies()
    {
        $testMapper = $this->getTestMapper();
        $testMapper->insert(array('company_id' => 1, 'name' => 'company'), 'contact_company');

        $mapper = $this->getMapper();
        $result = $mapper->getAll();
        $this->assertTrue(is_array($result));
        $this->assertInstanceOf('\SpeckCatalog\Model\Company', $result[0]);
    }
}
