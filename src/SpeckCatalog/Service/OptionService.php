<?php

namespace SpeckCatalog\Service;

class OptionService
{
    protected $optionMapper;
    protected $choiceService;
    
    public function getOptionById($id)
    {
        $option = $this->optionMapper->getOptionById($id);
        return $this->populateOption($option);

    }
    
    public function getOptionsByProductId($productId)
    {
        $options = $this->optionMapper->getOptionsByProductId($productId);
        foreach($options as $option){
            $return[] = $this->populateOption($option);
        }
        return $return;
    }

    public function populateOption($option)
    {
        $choices = $this->choiceService->getChoicesByParentOptionId($option->getOptionId());
        $option->setChoices($choices);
        return $option;
    }
    
    public function newProductOption($productId)
    {
        $option = $this->optionMapper->newModel();
        $this->optionMapper->linkOptionToProduct($productId, $option->getOptionId());
        return $option;
    }

    public function updateModelFromArray($arr)
    {
        $option = $this->optionMapper->instantiateModel($arr);
        return $this->optionMapper->update($option)->toArray();
    }  
    
    public function getModelsBySearchData($string)
    {
        return $this->optionMapper->getModelsBySearchData($string);
    }
    
    public function linkParent($productId, $optionId)
    {
        $this->optionMapper->linkOptionToProduct($productId, $optionId);
    }    

    public function add($option)
    {
        $this->optionMapper->add($option);
    }

    public function update($option)
    {
        $this->optionMapper->update($option);
    }

    public function getOptionMapper()
    {
        return $this->optionMapper;
    }

    public function setOptionMapper($optionMapper)
    {
        $this->optionMapper = $optionMapper;
        return $this;
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
}
