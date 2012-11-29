<?php

namespace Catalog\Form;

class Category extends AbstractForm
{
    protected $originalFields = array('category_id');

    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'category_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
    }
}
