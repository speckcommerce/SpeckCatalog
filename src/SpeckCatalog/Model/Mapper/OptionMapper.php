<?php

namespace SpeckCatalog\Model\Mapper;
use ZfcBase\Mapper\DbMapperAbstract,
    SpeckCatalog\Model\Option, 
    ArrayObject;

class OptionMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_option';
    protected $linkerTableName = 'catalog_product_option_linker';

    public function getOptionsByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->join($this->getLinkerTableName(), $this->getLinkerTableName().'.option_id = '.$this->getTableName().'.option_id') 
            ->where( $this->getLinkerTableName().'.product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $options = array();
            foreach($rows as $row){
                $options[] = $this->instantiateOption($row);
            }
            return $options;
        }
    }
    public function instantiateOption($row){
        $option = new Option();
        $option->setOptionId($row['option_id'])
               ->setName($row['name']);
        return $option;
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
        $data = new ArrayObject(array(
            'product_id'  => $product->getProductId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'type' => $product->getType(),
            'item_number' => $product->getItemNumber(),
            'manufacturer_company_id' => $product->getManufacturerCompanyId(),
        ));
        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('data' => $data));
        $db = $this->getWriteAdapter();
        if ('update' === $mode) {
            $db->update(
                $this->getTableName(), 
                (array) $data, 
                $db->quoteInto('product_id = ?', $product->getProductId())
            ); 
        } elseif ('insert' === $mode) {
            $db->insert($this->getTableName(), (array) $data);
        }
        return $product;
    }   

    public function getLinkerTableName(){
        return $this->linkerTableName;
    }

}
