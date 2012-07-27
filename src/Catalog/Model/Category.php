<?php

namespace Catalog\Model;

class Category extends LinkedModelAbstract
{
    protected $categoryId;

    /**
     * name
     *
     * @var string
     * @access protected
     */
    protected $name;

    /**
     * products
     *
     * @var array
     * @access protected
     */
    protected $products;

    /**
     * categories
     *
     * @var array
     * @access protected
     */
    protected $categories;

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

    public function __toString()
    {
        return '' . $this->getName();
    }

 /**
  * Get categoryId.
  *
  * @return categoryId.
  */
 function getCategoryId()
 {
     return $this->categoryId;
 }

 /**
  * Set categoryId.
  *
  * @param categoryId the value to set.
  */
 function setCategoryId($categoryId)
 {
     $this->categoryId = $categoryId;
 }

    public function getId()
    {
        return $this->categoryId();
    }
    public function setId($id)
    {
        return $this->setCategoryId($id);
    }
}
