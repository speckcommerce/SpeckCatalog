<?php
namespace Catalog\Model;
class Category extends ModelAbstract
{
    protected $categoryId;
    protected $products = array();
 
    public function getCategoryId()
    {
        return $this->categoryId;
    }
 
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getId()
    {
        return $this->getCategoryId();
    }
 
    public function getProducts()
    {
        return $this->products;
    }
 
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

    public function hasProducts()
    {
        if(count($this->getProducts()) > 0){
            return true;
        }
    }
}
