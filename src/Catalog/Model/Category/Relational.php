<?php

namespace Catalog\Model\Category;

use Catalog\Model\Category as Base;

class Relational extends Base
{
    protected $categories;
    protected $products;

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

    public function __toString()
    {
        $name = $this->getName();
        $parent = parent::__toString();
        return ($name ?: $parent);
    }
}
