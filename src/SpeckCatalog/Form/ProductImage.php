<?php

namespace SpeckCatalog\Form;

class ProductImage extends AbstractForm
{
    protected $originalFields = array('image_id');

    public function __construct()
    {
        parent::__construct();
    }
}
