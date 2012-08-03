<?php
namespace Catalog\Service;
class ImageService extends MediaServiceAbstract
{
    public function getImagesByProductId($productId)
    {
        $images = $this->getModelMapper()->getMediaByProductId($productId);
        return $images;
    }

    public function getImagesByOptionId($optionId)
    {
        $images = $this->getModelMapper()->getImagesByOptionId($optionId);
        return $images;
    }
    public function getImageForCategory($categoryId)
    {
        return $this->getModelMapper()->getImageForCategory($categoryId);
    }

    public function updateSortOrder($parent, $order)
    {
        $this->getModelMapper()->updateProductImageSortOrder($order);
    }

    public function linkParentOption($optionId, $mediaId)
    {
        return $this->getModelMapper()->linkParentOption($optionId, $mediaId);
    }
    public function linkParentCategory($categoryId, $mediaId)
    {
        return $this->getModelMapper()->linkParentCategory($categoryId, $mediaId);
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_image_mapper');
        }
        return $this->modelMapper;
    }
}
