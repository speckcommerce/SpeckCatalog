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

    public function updateSortOrder($parent, $order)
    {
        $this->getModelMapper()->updateProductImageSortOrder($order);
    }

    public function linkParentOption($optionId, $recordId)
    {
        return $this->getModelMapper()->linkParentOption($optionId, $recordId);
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_image_mapper');
        }
        return $this->modelMapper;
    }
}
