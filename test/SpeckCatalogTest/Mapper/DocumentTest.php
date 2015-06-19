<?php

namespace SpeckCatalogTest\Mapper;

use SpeckCatalogTest\Mapper\TestAsset\AbstractTestCase;

class DocumentTest extends AbstractTestCase
{
    public function testFindReturnsDocumentModel()
    {
        $documentId = $this->insertDocument();

        $mapper = $this->getMapper();
        $return = $mapper->find(array('document_id' => $documentId));
        $this->assertTrue($return instanceof \SpeckCatalog\Model\Document);
    }

    public function testGetByProductIdReturnsArrayOfDocumentModels()
    {
        $testMapper = $this->getTestMapper();
        $testMapper->insert(array('product_id' => 99), 'catalog_product_document');

        $mapper = $this->getMapper();
        $return = $mapper->getByProductId(99);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\Document', $return[0]);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_document_mapper');
    }
}
