<?php

namespace SpeckCatalog\Form;

class Document extends AbstractForm
{
    protected $originalFields = ['document_id'];

    public function __construct()
    {
        parent::__construct();
        $this->add([
            'name' => 'document_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'product_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'label',
            'options' => [
                'label' => 'Label',
            ],
        ]);
        $this->add([
            'name' => 'file_name',
            'options' => [
                'label' => 'FileName',
            ],
        ]);
    }
}
