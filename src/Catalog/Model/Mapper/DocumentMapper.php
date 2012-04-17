<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Document,
    ArrayObject;
class DocumentMapper extends MediaMapperAbstract
{
    protected $linkerTableName = 'catalog_product_document_linker';
    
    public function getModel()
    {
        return new Document;
    }

    public function getModelClass()
    {
        return 'media';
    } 

    public function getDocumentsByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getLinkerTableName())
            ->join(
                $this->getTableName(), 
                $this->getLinkerTableName().'.media_id = '.$this->getTableName().'.media_id'
            )       
            ->where('product_id = ?', $productId)
            ->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        $specs = array();
        if (count($rows) > 0){
            foreach($rows as $row){
                $specs[] = $this->mapModel($row);
            }
        }  
        return $specs;
    }    

    public function linkParentProduct($productId, $documentId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getLinkerTableName())
            ->where('product_id = ?', $productId)
            ->where('media_id = ?', $documentId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'product_id'  => $productId,
                'media_id' => $documentId,
            ));
            $db->insert($this->getLinkerTableName(), (array) $data);
        }
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
