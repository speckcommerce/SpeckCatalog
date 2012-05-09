<?php

namespace Catalog\Service;

class OptionService extends ServiceAbstract
{
    protected $choiceService;
    protected $productService;
    
    public function _populateModel($option)
    {
        $optionId = $option->getRecordId();
        $parentProducts = $this->getProductService()->getProductsByChildOptionId($optionId);
        $option->setParentProducts($parentProducts);
        $parentChoices = $this->getChoiceService()->getChoicesByChildOptionId($optionId);
        $option->setParentChoices($parentChoices);
        
        $choices = $this->getChoiceService()->getChoicesByParentOptionId($optionId);
        if($choices){
            $option->setChoices($choices);
        }
        return $option;
    }
    
    public function getOptionsByProductId($productId)
    {
        $options = $this->getModelMapper()->getOptionsByProductId($productId);
        return $this->populateModels($options);
    }

    public function getOptionsByChoiceId($choiceId)
    {
        $options = $this->modelMapper->getOptionsByChoiceId($choiceId);
        return $this->populateModels($options);
    }

    public function updateSortOrder($parent, $order)
    {
        if('product' === $parent){
            $this->getModelMapper()->updateProductOptionSortOrder($order);
        }
        if('choice' === $parent){
            $this->getModelMapper()->updateChoiceOptionSortOrder($order);
        }
    }

    public function linkParentChoice($choiceId, $optionId)
    {
        return $this->getModelMapper()->linkOptionToChoice($choiceId, $optionId);
    }
    
    public function linkParentProduct($productId, $optionId)
    {
        return $this->getModelMapper()->linkOptionToProduct($productId, $optionId);
    }    

    public function getChoiceService()
    {
        return $this->choiceService;
    }
 
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }

    public function getProductService()
    {
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
}
