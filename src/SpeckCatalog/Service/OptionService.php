<?php

namespace SpeckCatalog\Service;

class OptionService extends ServiceAbstract
{
    protected $choiceService;
    
    public function getOptionsByProductId($productId)
    {
        $options = $this->modelMapper->getOptionsByProductId($productId);
        $return = array();
        foreach($options as $option){
            $return[] = $this->populateModel($option);
        }
        return $return;
    }

    public function populateModel($option)
    {
        $choices = $this->getChoiceService()->getChoicesByParentOptionId($option->getOptionId());
        $option->setChoices($choices);
        return $option;
    }
    
    public function newProductOption($productId)
    {
        $option = $this->modelMapper->newModel();
        $this->modelMapper->linkOptionToProduct($productId, $option->getOptionId());
        return $option;
    }
    
    public function linkParent($productId, $optionId)
    {
        $this->modelMapper->linkOptionToProduct($productId, $optionId);
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
