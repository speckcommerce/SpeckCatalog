<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;


class CatalogController extends AbstractActionController implements ServiceLocatorAwareInterface
{
    protected $catalogService;
    protected $modelLinkerService;
    protected $serviceManager;

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function indexAction()
    {
        return new ViewModel;
    }

    public function productAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $productService = $this->getServiceLocator()->get('catalog_product_service');
        $product = $productService->getById($id, true, true);

        return new ViewModel(array('product' => $product));
    }

    public function productRedirectAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        return $this->redirect()->toRoute('catalog/product', array('id' => $id));
    }

    public function categoryAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $category = $this->getCatalogService()->getModel('category', $id);
        var_dump($category);
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
