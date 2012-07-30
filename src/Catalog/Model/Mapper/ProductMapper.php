<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Product,
    ArrayObject;

class ProductMapper extends ModelMapperAbstract
{
    protected $primaryKey = 'product_id';
    protected $tableName = 'catalog_product';
    protected $childOptionLinkerTableName = 'catalog_product_option_linker';
    protected $parentCategoryLinkerTableName = 'catalog_category_product_linker';

    public function __construct()
    {
        $unsetKeys = array('options', 'parent_choices', 'manufacturer', 'uoms', 'specs', 'documents', 'images');
        parent::__construct($unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new Product($constructor);
    }

    public function getProductsByCategoryId($categoryId)
    {
        $linker = $this->parentCategoryLinkerTableName;
        $select = $this->select()
                  ->from($this->tableName)
                  ->join($linker, $linker . '.product_id = '.$this->tableName.'.product_id')
                  ->where(array($linker . '.category_id' => $categoryId));
        return $this->selectMany($select);
    }

    public function getProductsByChildOptionId($optionId)
    {
        $linkerName = $this->childOptionLinkerTableName;
        $select = $this->select()->from($this->tableName)
            ->join($linkerName, $this->tableName . '.product_id = '. $linkerName .'.product_id')
            ->where(array('option_id' => $optionId));
            //->order('sort_weight DESC');
        return $this->selectMany($select);
    }

    public function linkParentCategory($categoryId, $productId)
    {
        $row = array(
            'product_id' => $productId,
            'category_id' => $categoryId,
        );
        return $this->add($row, $this->parentCategoryLinkerTableName);
    }
}
