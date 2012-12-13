<?php

namespace SpeckCatalogTest\Mapper;
use SpeckCatalogTest\Mapper\Asset\AbstractTestCase;

class DocumentTest extends AbstractTestCase
{
    public function testFindReturnsDocumentModel()
    {
        $documentId = $this->insertDocument();

        $mapper = $this->getMapper();
        $return = $mapper->find(array('document_id' => $documentId));
        $this->assertTrue($return instanceOf \SpeckCatalog\Model\Document);
    }

    public function testGetDocumentsReturnsArrayOfDocumentModels()
    {
        $this->insertDocument(1);

        $mapper = $this->getMapper();
        $return = $mapper->getDocuments(1);
        $this->assertTrue(is_array($return));
        $this->assertTrue($return[0] instanceOf \SpeckCatalog\Model\Document);
    }

    public function getMapper()
    {
        return $this->getServiceManager()->get('speckcatalog_document_mapper');
    }
}
