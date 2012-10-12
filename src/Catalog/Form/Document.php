<?php

namespace Catalog\Form;

class Document extends AbstractForm
{
    protected $originalFields = array('document_id');

    public function __construct()
    {
        parent::__construct();
        $this->add(array(
            'name' => 'document_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'product_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'label',
            'options' => array(
                'label' => 'Label',
            ),
        ));
        $this->add(array(
            'name' => 'file_name',
            'options' => array(
                'label' => 'FileName',
            ),
        ));
    }
}
