<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Image,
    ArrayObject;
class ImageMapper extends MediaMapperAbstract
{
    protected $linkerTableName = 'catalog_product_image_linker';
    
    public function getModel()
    {
        return new Image;
    }

    public function getImagesByProductId($productId)
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

        return $this->rowsToModels($rows);
    }    

    public function linkParentProduct($productId, $imageId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getLinkerTableName())
            ->where('product_id = ?', $productId)
            ->where('media_id = ?', $imageId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'product_id'  => $productId,
                'media_id' => $imageId,
            ));
            $db->insert($this->getLinkerTableName(), (array) $data);
        }
        return $db->lastInsertId();
    }  

    public function updateProductImageSortOrder($order)
    {
        return $this->updateSort('catalog_product_image_linker', $order);
    }
    
    public function removeLinker($linkerId)
    {
        return $this->deleteLinker('catalog_product_image_linker', $linkerId);
    }
}

