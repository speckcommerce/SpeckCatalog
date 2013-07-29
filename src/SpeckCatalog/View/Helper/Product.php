<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Product extends AbstractHelper
{
    protected $productUomService;

    public function __invoke()
    {
        return $this;
    }

    public function uomString($product)
    {
        if ($product->has('uoms')) {
            $svc = $this->getProductUomService();
            $uom = $svc->cheapestUom($product->getUoms());
            $svc->populate($uom);
            $moreThan1 = ($uom->getQuantity() > 1);

            $string = $uom->getUom()->getName();
            if ($moreThan1) {
                $string .= ' of ' . $uom->getQuantity();
            }
            return $string;
        }

        return 'Starting At'; //todo : if there are builders, get the uomString from the one we are displaying the price from
    }

    public function itemNumbers($product, $implode=false)
    {
        $numbers = array();
        if ($product->getProductTypeId() == 2) {
            $numbers[$product->getItemNumber()] = $product->getItemNumber();
        } else {
            foreach ($product->getBuilders() as $builder) {
                $bp = $builder->getProduct();
                $numbers[$bp->getItemNumber()] = $bp->getItemNumber();
            }
        }
        if ($implode) {
            return implode($implode, $numbers);
        }
        return $numbers;
    }

    public function getProductUomService()
    {
        return $this->productUomService;
    }

    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }
}
