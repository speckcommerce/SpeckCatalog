<?php
namespace Catalog\Form\Definition;
use SpiffyAnnotation\Form,
    SpiffyForm\Form\Manager,
    SpiffyForm\Form\Definition;

 
class Shell implements Definition
{
    public function build(Manager $m)
    {
        $m
          ->add('name')
          ->add('description')
          ->add('price')
          ->add('submit', 'submit', array(
              'label' => 'Save Changes',
          ))
          ->add('cancel', 'submit', array(
              'label' => 'Cancel Changes'
          ));
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
        return array('data_class' => 'Management\Entity\Shell');
    }
}
