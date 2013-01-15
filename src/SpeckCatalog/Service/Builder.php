<?php

namespace SpeckCatalog\Service;

class Builder extends AbstractService
{
    protected $entityMapper = 'speckcatalog_builder_mapper';

    public function insert($data)
    {
        foreach($data as $product) {
            foreach($product as $productId => $choiceIds) {
                foreach ($choiceIds as $choiceId) {
                    $data = array('product_id' => $productId, 'choice_id' => $choiceId);
                    return parent::insert($data);
                }
            }
        }
    }

}
