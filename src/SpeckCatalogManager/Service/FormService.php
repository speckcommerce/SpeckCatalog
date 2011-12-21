<?php
namespace SpeckCatalogManager\Service;
class FormService
{
    protected $forms = array();
    protected $locator;

    public function __construct($locator)
    {
        $this->locator = $locator;
    }
    
    public function getProductForms($product)
    {
        $this->forms['blank']['choice'] = $this->getFormManager(null, 'Choice')->getForm();
        $this->forms['blank']['option-radio'] = $this->getFormManager(null, 'Option')->getForm();
        $this->forms['blank']['item-uom'] = $this->getFormManager(null, 'ItemUom')->getForm();
        
        $this->forms['product'] = $this->getFormManager($product)->getForm();
        $returnedItem = $product->getItem();
        if($returnedItem){
            $this->forms['item'] = $this->getFormManager($returnedItem)->getForm();
            $returnedItemUoms = $returnedItem->getUoms();
            if($returnedItemUoms){
                foreach($returnedItemUoms as $itemUom){
                    $this->forms['item-uoms'][$itemUom->getItemUomId()] = $this->getFormManager($itemUom)->getForm();
                }
            }
        }
        $returnedOptions = $product->getOptions();
        if($returnedOptions){
            foreach($returnedOptions as $option){
                $this->forms['options'][$option->getOptionId()] = $this->getFormManager($option)->getForm();
                $returnedChoices = $option->getChoices();
                if($returnedChoices){
                    foreach($returnedChoices as $choice){
                        $this->forms['choices'][$choice->getChoiceId()] = $this->getFormManager($choice)->getForm();
                    }
                }
            }
        }
        return $this->forms;
    }

    private function getFormManager($entity=null, $className=null)
    {
        if($entity){ 
            $class = explode('\\', get_class($entity)); $className = array_pop($class);  
        }
        $definitionClass = 'SpeckCatalog\Form\Definition\\'.$className;
        if(!class_exists($definitionClass)){
            die("sorry, dont have that definition class - {$className}, couldnt get your formManager");
        }
        return $this->locator->get('spiffy_form', array('definition' => $definitionClass, 'data' => $entity,))->build();
    }      
}
