<?php

namespace Catalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class CatalogManagerCategoryTree extends AbstractHelper
{
    public function __invoke()
    {
        $view = new ViewModel();
        $view->setTemplate('catalog/catalog-manager/partial/category-tree');

        return $this->getView()->render($view);
    }
}
