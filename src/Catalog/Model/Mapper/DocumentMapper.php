<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Document,
    ArrayObject;
class DocumentMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_document';
    protected $productLinkerTableName = 'catalog_product_document_linker';

    public function getModel($constructor=null)
    {
        return new Document($constructor);
    }

    public function getByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getProductLinkerTableName())
            ->join(
                $this->getTableName(), 
                $this->getProductLinkerTableName().'.document_id = '.$this->getTableName().'.document_id'
            )       
            ->where('product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $specs = array();
            foreach($rows as $row){
                $specs[] = $this->mapModel($row);
            }
            return $specs;
        }else{
            return array();
        }  
    } 

    public function linkParentProduct($productId, $documentId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getProductLinkerTableName())
            ->where('product_id = ?', $productId)
            ->where('document_id = ?', $documentId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'product_id' => $productId,
                'document_id'  => $documentId,
            ));
            $db->insert($this->getProductLinkerTableName(), (array) $data);
        }
    }  

    public function getProductLinkerTableName()
    {
        return $this->productLinkerTableName;
    }

    public function setProductLinkerTableName($productLinkerTableName)
    {
        $this->productLinkerTableName = $productLinkerTableName;
        return $this;
    }
}
