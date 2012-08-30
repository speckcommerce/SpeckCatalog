<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Exception;

class CategoryController extends AbstractActionController
{
    protected $catalogService;

    public function indexAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $category = $this->getServiceLocator()->get('catalog_category_service')->getCategoryForView($id);
        if (null === $category) {
            throw new \Exception('fore oh fore');
        }

        return new ViewModel(array('category' => $category));
    }

    function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
    }

    function getCatalogService()
    {
        return $this->catalogService;
    }
}
