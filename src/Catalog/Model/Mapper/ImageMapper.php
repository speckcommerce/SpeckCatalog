<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Image,
    ArrayObject;
class ImageMapper extends MediaMapperAbstract
{
    public function getModel($constructor=null)
    {
        return new Image;
    }

    public function linkParentProduct($productId, $imageId)
    {   
        $table = $this->getLinkerTable();
        $row = array(
            'product_id' => $productId,
            'media_id' => $imageId,
        );
        return $this->insertLinker($table, $row);    
    }
    public function linkParentOption($optionId, $imageId)
    {
        $table = $this->getParentOptionLinkerTable();
        $row = array(
            'option_id' => $productId,
            'media_id' => $imageId,
        );
        return $this->insertLinker($table, $row);     
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

