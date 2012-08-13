<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ProductController extends AbstractActionController
{
    protected $catalogService;
    protected $modelLinkerService;

    public function indexAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $productService = $this->getServiceLocator()->get('catalog_product_service');
        $product = $productService->getById($id, true, true);
        if(null === $product){
            throw new \Exception('fore oh fore');
        }
        return new ViewModel(array('product' => $product));
    }

    public function getCatalogService()
    {
        if(null === $this->catalogService){
            $this->catalogService = $this->getServiceLocator()->get('catalog_generic_service');
        }
        return $this->catalogService;
    }

    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }

    public function getModelLinkerService()
    {
        return $this->modelLinkerService;
    }

    public function setModelLinkerService($modelLinkerService)
    {
        $this->modelLinkerService = $modelLinkerService;
        return $this;
    }
}
