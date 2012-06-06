<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Exception;

class CatalogController extends ActionController
{
    protected $catalogService;
    protected $modelLinkerService;

    public function indexAction()
    {
        return new ViewModel;
    }

    public function productAction()
    {
        $translateThis = "°™";
        $var = htmlentities($translateThis, ENT_QUOTES, "UTF-8", true, false);
        //die($var);

        
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $product = $this->getCatalogService()->getModel('product', $id);
        var_dump($product);
    }
    
    public function productRedirectAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $this->redirect()->toRoute('catalog/product', array('id' => $id));
    }

    public function categoryAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $category = $this->getCatalogService()->getModel('category', $id);
        var_dump($category);
    }   
    
    public function getCatalogService()
    {
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
