<?php

namespace SpeckCatalog\Event;

class FrontendEnabled
{
    /*
     * After insert/update of a productuom,
     * check all uoms belonging to that product,
     * if any productuom is enabled, enable the product,
     * otherwise, disable it.
     *
     */

    public function insertProductUom($e)
    {
        $dbResult = $e->getParam('result');
        if (!count($dbResult)) {
            return; //no rows affected
        }

        $productId      = is_array($e->getParam('data'))
                        ? $e->getParam('data')['product_id']
                        : $e->getParam('data')->getProductId();
        $productService = $e->getTarget()->getProductService();
        $find           = array('product_id' => $productId);
        $product        = $productService->find($find, array('uoms'));

        $enabled = $this->canProductBeEnabled($product);

        $productService->setEnabledProduct($productId, $enabled);
    }

    public function updateProductUom($e)
    {
        $productUomService = $e->getTarget();
        $productService    = $productUomService->getProductService();

        $where = $e->getParam('where');
        $uoms  = $productUomService->findRows($where);

        $ids = array();
        foreach ($uoms as $uom) {
            $ids[$uom['product_id']] = $uom['product_id'];
        }
        $products = $productService->getProductsById($ids);

        foreach ($products as $product) {
            $productService->populate($product, array('uoms'));
            $row = array(
                'product_id' => $productId,
                'enabled'    => $this->canProductBeEnabled($product)
            );
            $where = array('product_id' => $productId);
            $productService->update($row, $where);
        }
    }

    public function canProductBeEnabled($product)
    {
        if ($product->getProductTypeId() == 2) {
            return true;
        }
        foreach ($product->getUoms() as $uom) {
            if ($uom->getEnabled()) {
                return true;
            }
        }
        return false;
    }

    /*
     * After insert/update of product(s),
     * find any choices that reference the product,
     * if the product is enabled, enable the choice,
     * otherwise, disable it.
     *
     */

    public static function updateProduct($e)
    {
        $productService = $e->getTarget();
        $choiceService  = $productService->getChoiceService();

        $where = $e->getParam('where');
        $products = $productService->findMany($where, array('uoms'));

        foreach ($products as $product) {
            $productId = $product->getProductId();
            $enabled   = ($product->getEnabled()) ? 1 : 0;
            $choiceService->update(
                array('enabled'    => $enabled), //data
                array('product_id' => $productId)    //where
            );
        }

        $productIds = $e->getTarget();
    }

    public static function insertProduct($e)
    {
        $result = $e->getParam('result');
        if (!$result) {
            return;
        }
        $productId      = $result;
        $data           = array('product_id' => $productId);

        $productService = $e->getTarget();
        $product        = $productService->find($data);

        $enabled        = ($product->getEnabled()) ? 1 : 0;

        $choiceService  = $productService->getChoiceService();
        $choiceService->update(
            array('enabled'    => $enabled), //data
            array('product_id' => $productId)    //where
        );
    }
}
