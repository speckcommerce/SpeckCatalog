<?php
namespace Catalog\Model;
class Category extends ModelAbstract
{
    protected $categoryId;
    protected $name;
    protected $products = array();
    protected $categories = array();

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

    public function getName()
    {
        return $this->name;
    }
 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function hasCategories()
    {
        if(count($this->getCategories()) > 0){
            return true;
        }
    }

    public function getCategories()
    {
        return $this->categories;
    }
 
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }
}
