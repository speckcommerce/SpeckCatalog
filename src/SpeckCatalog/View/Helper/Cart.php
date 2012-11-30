<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;


//todo: this is not really a view helper.. find a better home for this
class Cart extends AbstractHelper
{
    public function __invoke()
    {
        return $this;
    }

    public function options($cartItems)
    {
        $options = array();
        foreach($cartItems as $i => $cartItem){
            $itemMeta = $cartItem->getMetaData();
            $parentOptionId = $itemMeta->getParentOptionId();
            $options[$parentOptionId]['choices'][] = $cartItem;
            if (!isset($options[$parentOptionId]['option'])) {
                $options[$parentOptionId]['option'] = $itemMeta->getParentOptionName();
            }
            unset($cartItems[$i]);
        }
        return $options;
    }
}
