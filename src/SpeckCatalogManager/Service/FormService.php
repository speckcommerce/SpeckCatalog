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
        
        
        $this->forms['blank']['option-radio'] = $this->getFormManager(null, 'Option')->getForm();

        $this->forms['form'] = $this->getFormManager($product)->getForm();
        $returnedItem = $product->getItem();
        if($returnedItem){
            $this->forms['item']['form'] = $this->getFormManager($returnedItem)->getForm();
        }
        $returnedOptions = $product->getOptions();
        if($returnedOptions){
            $options = array();
            foreach($returnedOptions as $option){
                $options[$option->getOptionId()]['form'] = $this->getFormManager($option)->getForm();
                $returnedChoices = $option->getChoices();
                if($returnedChoices){
                    $choices = array();
                    foreach($returnedChoices as $choice){
                        $choices[$choice->getChoiceId()]['form'] = $this->getFormManager($choice)->getForm();
                    }
                    $options[$option->getOptionId()]['choices'] = $choices;
                }
            }
            $this->forms['options'] = $options;
        }
        return $this->forms;
    }





    private function getFormManager($entity=null, $className=null)
    {
        if(!$className){ 
            $class = explode('\\', get_class($entity)); $className = array_pop($class);  
        }
        $definitionClass = 'SpeckCatalog\Form\Definition\\'.$className;
        return $this->locator->get('spiffy_form', array('definition' => $definitionClass, 'data' => $entity,))->build();
    }      
}
