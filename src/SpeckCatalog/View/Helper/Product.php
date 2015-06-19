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
        // @TODO: if there are builders, get the uomString from the one we are
        //displaying the price from
        return 'Starting At';
    }



    public function allUomsString($product, $string = true)
    {
        $uomStrings = array();

        if ($product->type() === 'product') {
            foreach ($uoms as $uom) {
                $uomStrings[$this->uomStr($uom)] = $this->uomName($uom);
            }
        } elseif ($product->type() === 'shell') {
            foreach ($product->getBuilders() as $builder) {
                foreach ($builder->getProduct()->getUoms() as $uom) {
                    $uomStrings[$this->uomStr($uom)] = $this->uomName($uom);
                }
            }
        }

        if ($string) {
            return implode(',', $uomStrings);
        }

        return $uomStrings;
    }

    public function uomStr($uom)
    {
        return $uom->getUomCode() . $uom->getQuantity();
    }

    public function uomName($uom)
    {
        if ($uom->getQuantity() === 1) {
            return $uom->getUom()->getName();
        }
        return "{$uom->getUom()->getName()} of {$uom->getQuantity()}";
    }

    public function itemNumbers($product, $implode = false)
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
