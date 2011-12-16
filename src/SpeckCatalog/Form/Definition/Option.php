<?php
namespace SpeckCatalog\Form\Definition;
use SpiffyAnnotation\Form,
    SpiffyForm\Form\Manager,
    SpiffyForm\Form\Definition,
    SpeckCatalogManager\Entity\Option as OptionEntity;


 
class Option implements Definition
{
    public function build(Manager $m)
    {
        $m
          ->add('name');
    }

    public function isValid($params, $form)
    {
        return true;
    }

    public function getName()
    {
        return 'update';
    }

    public function getOptions()
    {
        return array();
        // return array('data_class' => new OptionEntity('radio'));
    }
}
