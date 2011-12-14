<?php
namespace SpeckCatalog\Form\Definition;
use SpiffyAnnotation\Form,
    SpiffyForm\Form\Manager,
    SpiffyForm\Form\Definition;

 
class Product implements Definition
{
    public function build(Manager $m)
    {
        $m
          ->add('name')
          ->add('description')
          ->add('price')
          ->add('type');
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
        return array('data_class' => 'Management\Entity\Product');
    }
}
