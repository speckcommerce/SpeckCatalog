<?php

namespace Catalog\Service;

class CategoryService extends ServiceAbstract
{
    public function populateModel($category)
    {
        $categories = $this->getModelMapper->getChildCategories($category->getCategoryId());
        if($categories){
            $category->setCategories($categories);
        }
        return $category;   
    }   
}
