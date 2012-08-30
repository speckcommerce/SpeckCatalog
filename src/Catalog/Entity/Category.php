<?php

namespace Catalog\Entity;

class Category extends AbstractEntity
{
    protected $categoryId;
    protected $name;
    protected $seoTitle;
    protected $descriptionHtml;

    //non db fields
    protected $categories;
    protected $products;

    /**
     * @return categoryId
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param $categoryId
     * @return self
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return seoTitle
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * @param $seoTitle
     * @return self
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;
        return $this;
    }

    /**
     * @return descriptionHtml
     */
    public function getDescriptionHtml()
    {
        return $this->descriptionHtml;
    }

    /**
     * @param $descriptionHtml
     * @return self
     */
    public function setDescriptionHtml($descriptionHtml)
    {
        $this->descriptionHtml = $descriptionHtml;
        return $this;
    }

    /**
     * @return categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param $categories
     * @return self
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param $products
     * @return self
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }
}
