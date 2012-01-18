<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Product, 
    SpeckCatalog\Model\Item,
    ArrayObject;

class ProductMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_product';
    protected $modelClass = 'product';

    public function instantiateModel($row)
    {
        $product = new Product();
        $product->setProductId($row['product_id'])
                ->setName($row['name'])
                ->setDescription($row['description'])
                ->setType($row['type']);
            
        if($row['type'] ==='item'){ 
            $product->setItemNumber($row['item_number'])
                    ->setManufacturerCompanyId($row['manufacturer_company_id']);
        }     

        $this->events()->trigger(__FUNCTION__, $this, array('model' => $product));

        return $product;  
    }
}
