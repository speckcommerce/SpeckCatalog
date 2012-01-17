<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Product, 
    SpeckCatalog\Model\Item,
    ArrayObject;

class ProductMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_product';
    
    public function getProductById($id)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where( 'product_id = ?', $id);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);

        return $this->instantiateModel($row);
    }
    
    public function newModel($type)
    {
        $product = new Product($type);
        return $this->add($product);
    }

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

    public function add(Product $product)
    {
        return $this->persist($product);
    }

    public function update(Product $product)
    {
        return $this->persist($product, 'update');
    }       

    public function persist(Product $product, $mode = 'insert')
    {
        $data = new ArrayObject($product->toArray());
        $data['search_data'] = $product->getSearchData();
        
        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('data' => $data));
        $db = $this->getWriteAdapter();
        
        if ('update' === $mode) {
            $db->update($this->getTableName(), (array) $data, $db->quoteInto('product_id = ?', $product->getProductId())); 
        } elseif ('insert' === $mode) {
            $db->insert($this->getTableName(), (array) $data);
            $product->setProductId($db->lastInsertId());
        }

        return $product;
    }   

}
