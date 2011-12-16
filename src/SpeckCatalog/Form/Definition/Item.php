<?php
namespace SpeckCatalog\Form\Definition;
use SpiffyAnnotation\Form,
    SpiffyForm\Form\Manager,
    SpiffyForm\Form\Definition;

 
class Item implements Definition
{
    public function build(Manager $m)
    {
        $m
            ->add('item_number');

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
        return array('data_class' => 'SpeckCatalogManager\Entity\Item');
    }
}
