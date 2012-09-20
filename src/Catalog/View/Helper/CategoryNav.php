<?php

namespace Catalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;

class CategoryNav extends AbstractHelper
{
    protected $categoryService;

    protected $partialDir = 'catalog/catalog/partial/';

    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }

    function getCatalogService()
    {
        return $this->catalogService;
    }

    public function __invoke()
    {
        $categories = $this->getCategoryService()->getCategoriesForNavigation();
        $view = new ViewModel(array('categories' => $categories));
        $view->setTemplate($this->partialDir . 'categories.phtml');
        return $this->getView()->render($view);
    }

    public function getCategoryService()
    {
        return $this->categoryService;
    }

    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
        return $this;
    }
}
