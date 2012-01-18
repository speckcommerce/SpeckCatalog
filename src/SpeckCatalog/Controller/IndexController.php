<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    protected $productService;

    public function indexAction()
    {
        return array();
    }
    
    public function productAction()
    {
        $productService = $this->getProductService();
        return array('product' => $productService->getModelById($_GET['id']));
    }

    public function getProductService()
    {
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
}   
