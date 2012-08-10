<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Exception;
use Catalog\Service\CatalogServiceAwareInterface;

class CategoryController extends AbstractActionController implements CatalogServiceAwareInterface
{
    protected $catalogService;

    public function indexAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $category = $this->getCatalogService()->getService('category')->getCategoryForView($id);
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
