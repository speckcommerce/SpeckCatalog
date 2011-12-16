<?php
namespace SpeckCatalog\Form\Definition;
use SpiffyAnnotation\Form,
    SpiffyForm\Form\Manager,
    SpiffyForm\Form\Definition;

 
class Choice implements Definition
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
        return array('data_class' => 'Management\Entity\Choice');
    }
}
