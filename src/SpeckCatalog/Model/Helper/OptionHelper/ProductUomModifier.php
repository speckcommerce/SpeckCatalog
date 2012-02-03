<?php
namespace SpeckCatalog\Model\Helper\OptionHelper;
use SpeckCatalog\Model\Helper;

class ProductUomModifier extends OptionHelper
{
    protected $productUomId;

    protected $fixedDiscount;
    protected $percentDiscount;
    protected $fixedPrice;
    protected $isStandardEquipment;

    protected $productUom;
    public function modify($option)
    {
        foreach($this->option->getChoices() as $choice){
            if($choice->hasProduct() && $choice->getProduct()->hasUoms()){
                foreach($choice->getProduct()->getUoms() as $productUom){
                    if($productUomId === $productUom->getProductUomId()){
                        $this->productUom = $productUom;
                    }
                }
            }
        }

        //logic to mofidy the ProductUom;
        $this->productUom->setPrice(1234.99);
        return $this->option;
    }
}
