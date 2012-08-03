<?php

namespace Catalog\Model;

class Category extends LinkedModelAbstract
{
    protected $categoryId;

    protected $name;

    protected $title;

    protected $descriptionHtml;

    protected $image;

    protected $products;

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

    function getCategoryId()
    {
        return $this->categoryId;
    }

    function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getId()
    {
        return $this->categoryId;
    }

    public function setId($id)
    {
        return $this->setCategoryId($id);
    }

    function getDescriptionHtml()
    {
        return $this->descriptionHtml;
    }

    function setDescriptionHtml($descriptionHtml)
    {
        $this->descriptionHtml = $descriptionHtml;
    }

    function getImage()
    {
        return $this->image;
    }

    function setImage($image)
    {
        $this->image = $image;
    }

    function getTitle()
    {
        return $this->title;
    }

    function setTitle($title)
    {
        $this->title = $title;
    }
}
