<?php

namespace Catalog\Hydrator;

class Image extends AbstractHydrator
{
    protected $nonDbFields = array('parent_type', 'parent_id');

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }

    public function extract($object)
    {
        $data = parent::extract($object);
        $data = $this->unsetKeys($data);

        switch ($object->getParentType()) {
            case 'product' :
                $data['product_id'] = $object->getParentId();
                break;
            case 'option' :
                $data['option_id'] = $object->getParentId();
                break;
        }
        return $data;
    }

    public function hydrate(array $data, $object)
    {
        if(isset($data['product_id'])) {
            $data['parent_id'] = $data['product_id'];
        }
        if(isset($data['option_id'])) {
            $data['parent_id'] = $data['option_id'];
        }

        return parent::hydrate($data, $object);
    }

}
