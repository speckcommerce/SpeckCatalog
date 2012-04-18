<?php

namespace Catalog\Service;

class ChoiceService extends ServiceAbstract
{
    protected $productService;
    protected $optionService;
    
    public function getChoicesByParentOptionId($id)
    {
        $choices = $this->modelMapper->getChoicesByParentOptionId($id);
        $return = array();
        foreach ($choices as $choice){
            $return[] = $this->populateModel($choice);
        }
        return $return;
    }

    public function populateModel($choice)
    {
        if($choice->getProductId()){
            $product = $this->productService->getById($choice->getProductId());
            if($product){ 
                $choice->setProduct($product); 
            }
        }
        $choice->setOptions($this->getOptionService()->getOptionsByChoiceId($choice->getChoiceId()));

        return $choice;
    }
    
    public function newOptionChoice($optionId)
    {
        $choice = $this->newModel();
        return $choice;
    }

    public function newOptionChoiceWithExistingProduct($optionId, $productId)
    {
        $choice = $this->newModel();
        $choice->setProductId($productId);
        $this->update($choice);
        $choice->setProduct($this->getProductService()->getById($productId));

        return $choice;
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
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
 
    public function getOptionService()
    {
        return $this->optionService;
    }
 
    public function setOptionService($optionService)
    {
        var_dump($optionService);
        $this->optionService = $optionService;
        return $this;
    }
}
