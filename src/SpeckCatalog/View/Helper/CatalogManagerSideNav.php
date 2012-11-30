<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class CatalogManagerSideNav extends AbstractHelper
{
    protected $routematch;

    public function __invoke()
    {
        $view = new ViewModel(array('action' => $this->getRouteMatch()->getParam('action')));
        $view->setTemplate('catalog/catalog-manager/partial/sidenav');

        return $this->getView()->render($view);
    }

    /**
     * @return routematch
     */
    public function getRoutematch()
    {
        return $this->routematch;
    }

    /**
     * @param $routematch
     * @return self
     */
    public function setRoutematch($routematch)
    {
        $this->routematch = $routematch;
        return $this;
    }
}
