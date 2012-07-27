<?php

namespace Catalog\Service;

class ChoiceService extends ServiceAbstract
{
    protected $productService;
    protected $optionService;

    public function _populateModel($choice)
    {
        if($choice->getProductId()){
            $product = $this->getProductService()->getById($choice->getProductId());
            if($product){
                $choice->setProduct($product);
            }
        }
        $choice->setOptions($this->getOptionService()->getOptionsByChoiceId($choice->getChoiceId()));

        return $choice;
    }

    public function getChoicesByParentOptionId($id)
    {
        $choices = $this->getModelMapper()->getChoicesByParentOptionId($id);
        $return = array();
        foreach ($choices as $choice){
            $return[] = $this->populateModel($choice);
        }
        return $return;
    }

    public function getChoicesByChildProductId($id)
    {
        return $this->getModelMapper()->getChoicesByChildProductId($id);
    }

    public function setChildProductId($choiceId, $productId)
    {
        $choice = $this->getModelMapper()->getById($choiceId);
        $choice->setProductId($productId);
        $this->getModelMapper()->update($choice);
    }

    public function getChoicesByChildOptionId($optionId)
    {
        return $this->getModelMapper()->getChoicesByChildOptionId($optionId);
    }

    public function updateSortOrder($parent, $order)
    {
        $this->getModelMapper()->updateOptionChoiceSortOrder($order);
    }

    public function linkParentOption($optionId, $choiceId)
    {
        return $this->getModelMapper()->linkParentOption($optionId, $choiceId);
    }

    public function getProductService()
    {
        if(null === $this->productService){
            $this->productService = $this->getServiceManager()->get('catalog_product_service');
        }
        return $this->productService;
    }

    public function getOptionService()
    {
        if(null === $this->optionService){
            $this->optionService = $this->getServiceManager()->get('catalog_option_service');
        }
        return $this->optionService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_choice_mapper');
        }
        return $this->modelMapper;
    }
}
