<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Spec extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'spec_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'label',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span3',
            ),
            'options' => array(
                'label' => 'Label',
            ),
        ));
        $this->add(array(
            'name' => 'value',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span3',
            ),
            'options' => array(
                'label' => 'Value',
            ),
        ));
    }
}
