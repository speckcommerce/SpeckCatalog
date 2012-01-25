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
        set_time_limit(0);
		error_reporting(E_ALL);
		@ini_set('zlib.output_compression', 0);
		@ini_set('implicit_flush', 1);
        ini_set('memory_limit',-1);     
        $productService = $this->getProductService();
        return array('product' => $productService->getById($_GET['id']));
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
