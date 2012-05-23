<?php
namespace Catalog\Service;
class ImageService extends MediaServiceAbstract
{
    public function getImagesByProductId($productId)
    {
        $images = $this->getModelMapper()->getMediaByProductId($productId);
        foreach($images as $i => $image){
            $images[$i] = $this->populateModel($image);
        }
        return $images;
    }

    public function getImagesByOptionId($optionId)
    {
        $images = $this->getModelMapper()->getImagesByOptionId($optionId);
        foreach($images as $i => $image){
            $images[$i] = $this->populateModel($image);
        }
        return $images;
    }
    
    public function updateSortOrder($parent, $order)
    {
        $this->getModelMapper()->updateProductImageSortOrder($order);
    }

    public function linkParentOption($optionId, $recordId)
    {
        return $this->getModelMapper()->linkParentOption($optionId, $recordId);
    }   
}
