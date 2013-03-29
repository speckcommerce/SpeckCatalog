<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Choice as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class Choice extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['choice_id']              = $model->getChoiceId();
        $data['product_id']             = $model->getProductId();
        $data['option_id']              = $model->getOptionId();
        $data['price_override_fixed']   = $model->getPriceOverrideFixed();
        $data['price_discount_percent'] = $model->getPriceDiscountPercent();
        $data['price_no_charge']        = ($model->getPriceNoCharge()) ? 1 : 0;
        $data['override_name']          = $model->getOverrideName();
        $data['sort_weight']            = $model->getSortWeight();

        return $data;
    }

    public function hydrate($data, $model)
    {
        $model = parent::hydrate($data, $model);
        $model->setPriceNoCharge( (bool) $model->getPriceNoCharge());

        return $model;
    }
}
