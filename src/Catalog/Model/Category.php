<?php
namespace Catalog\Model;
class Category extends ModelAbstract
{
    protected $categoryId;
 
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
}
