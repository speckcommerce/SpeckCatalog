<?php
namespace SpeckCatalogManager\Service;
use SpiffyForm\Form\Manager as FormManager,
    SpeckCatalogManager\Entity;


class FormService
{
    protected $forms = array();
    protected $depth = 0;



    /**
     * Somewhere, we need to check that choice->product is not a descendant of its 
     * parent product, or these functions will loop forever
     */

    public function getOptionForms($option)
    {
        $this->blankForms();
        $this->optionForms($option);
        return $this->forms;
    }

    public function getProductForms(Entity\Product $product)
    {
        $this->blankForms();
        $this->productForms($product);
        return $this->forms;
    }

    private function itemForms($item)
    {
        $this->forms['item'][$item->getItemId()] = $this->getFormManager($item)->getForm();
        $itemUoms = $item->getUoms();
        if($itemUoms){
            foreach($itemUoms as $itemUom){
                $this->itemUomForms($itemUom);
            }
        } 
    } 

    private function itemUomForms($itemUom)
    {
        $this->forms['item-uom'][$itemUom->getItemUomId()] = $this->getFormManager($itemUom)->getForm();
    }

    private function productForms($product)
    {
        $this->forms['product'][$product->getProductId()] = $this->getFormManager($product)->getForm();
        //var_dump($this->forms['product'][$product->getProductId()]);die();


        if($product->getType() === 'product'){
            $item = $product->getItem();
            if($item){
                $this->itemForms($item);
            }
        }
        $options = $product->getOptions();
        if(count($options) > 0){
            foreach($options as $option){
                $this->optionForms($option);
            }
        }
    }

    private function optionForms($option)
    {
        $this->depth++; if($this->depth > 200) die('over 200 options??');
        $this->forms['option'][$option->getOptionId()] = $this->getFormManager($option)->getForm();
        $returnedChoices = $option->getChoices();
        if(count($returnedChoices) > 0){
            foreach($returnedChoices as $choice){
                $this->choiceForms($choice);
            }
        }   
    }
    
    private function choiceForms($choice)
    {
        $this->forms['choice'][$choice->getChoiceId()] = $this->getFormManager($choice)->getForm();
        $product = $choice->getProduct();
        if($product){
            $this->productForms($product);
            $options = $product->getOptions();
            if(count($options) > 0){
                foreach($options as $option){
                    $this->optionForms($option);
                }
            }
        }    
    }
    
    private function blankForms()
    {
        $this->forms['blank']['availability'] = $this->getFormManager(null, 'Availability')->getForm();
        $this->forms['blank']['choice'] = $this->getFormManager(null, 'Choice')->getForm();
        $this->forms['blank']['option-radio'] = $this->getFormManager(null, 'Option')->getForm();
        $this->forms['blank']['item-uom'] = $this->getFormManager(null, 'ItemUom')->getForm();
        $this->forms['blank']['product'] = $this->getFormManager(new \SpeckCatalogManager\Entity\Product('shell'), 'Product')->getForm();
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

        $formManager = new FormManager(new $definitionClass, $entity);
        return $formManager->build();
    }      
}
