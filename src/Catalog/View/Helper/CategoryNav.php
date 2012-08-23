<?php

namespace Catalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use Catalog\Service\CatalogServiceAwareInterface;

class CategoryNav extends AbstractHelper implements CatalogServiceAwareInterface
{
    protected $catalogService;

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
        $categories = $this->getCatalogService()->getService('category')->getCategoriesForNavigation();
        $view = new ViewModel(array('categories' => $categories));
        $view->setTemplate($this->partialDir . 'categories.phtml');
        return $this->getView()->render($view);
    }
}
