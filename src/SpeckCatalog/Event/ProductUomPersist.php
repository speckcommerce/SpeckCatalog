<?php

namespace SpeckCatalog\Event;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ProductUomPersist implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /*
     * After insert/update of a productuom,
     * check all uoms belonging to that product,
     * if any productuom is enabled, enable the product,
     * otherwise, disable it.
     *
     */
    public static function postPersist($e)
    {
        $dbResult = $e->getParam('result');
        if (!count($dbResult)) {
            return; //no rows affected
        }

        $productId      = is_array($e->getParam('data'))
                        ? $e->getParam('data')['product_id']
                        : $e->getParam('data')->getProductId();
        $app            = $e->getParam('application');
        $productService = $e->getTarget()->getProductService();
        $product        = $productService->getFullProduct($productId);

        if (
            $product->getProductTypeId() == 1
            || $product->has('uoms') === false
        ) {
            return;
        }

        $enabled = false;
        foreach ($product->getUoms() as $uom) {
            if ($uom->getEnabled()) {
                $enabled = true;
            }
        }

        $productService->setEnabledProduct($productId, $enabled);
    }
}
