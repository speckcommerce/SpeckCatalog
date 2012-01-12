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
        $id=2;
        $product = $productService->getProductById($id);
        return array('product' => $product);
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
