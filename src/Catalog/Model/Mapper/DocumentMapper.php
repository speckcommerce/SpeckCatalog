<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Document,
    ArrayObject;
class DocumentMapper extends MediaMapperAbstract
{
    protected $parentProductLinkerTableName = 'catalog_product_document_linker';

    public function getModel($constructor=null)
    {
        return new Document;
    }

    public function linkParentProduct($productId, $documentId)
    {
        $table = $this->parentProductLinkerTableName;
        $row = array(
            'product_id' => $productId,
            'media_id' => $documentId,
        );
        return $this->insertLinker($table, $row);
    }

    public function updateProductDocumentSortOrder($order)
    {
        return $this->updateSort('catalog_product_document_linker', $order);
    }

    public function removeLinker($linkerId)
    {
        return $this->deleteLinker('catalog_product_document_linker', $linkerId);
    }
}
