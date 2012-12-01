<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class CatalogManagerCategoryTree extends AbstractHelper
{
    protected $partialDir = '/speck-catalog/catalog-manager/partial/';

    public function __invoke()
    {
        $view = new ViewModel();
        $view->setTemplate($this->partialDir . 'category-tree');

        return $this->getView()->render($view);
    }
}
