<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    protected $catalogService;
    protected $modelLinkerService;

    public function indexAction()
    {
        return new ViewModel;
    }

    public function productAction()
    {
        $product = $this->getCatalogService()->getModel('product', $_GET['id']);
        if($product){
            return new ViewModel(array('product' => $product));
        }else{
            return null;
        }
    }

    public function dropCatalogAction(){
        $this->getCatalogService()->dropCatalog();
    }
    public function createCatalogAction(){
        $this->getCatalogService()->createCatalog();
    }
    public function truncateCatalogAction(){
        $this->getCatalogService()->truncateCatalog();
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
