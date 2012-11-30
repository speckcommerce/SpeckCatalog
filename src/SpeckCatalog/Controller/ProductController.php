<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ProductController extends AbstractActionController
{
    protected $catalogService;
    protected $modelLinkerService;

    public function indexAction()
    {
        $cartItemId = $this->params('cartItemId');
        $cartService = $this->getServiceLocator()->get('speckcatalog_cart_service');
        $productService = $this->getServiceLocator()->get('speckcatalog_product_service');
        $product = $productService->getFullProduct($this->params('id')); //, true, true);
        if(!$product){
            throw new \Exception('no product for that id');
        }
        //var_dump($product); die();
        return new ViewModel(array(
            'product'     => $product,
            'editingCart' => ($cartItemId ? true : false),
            'cartItem'    => ($cartItemId ? $cartService->findItemById($cartItemId) : false),
        ));
    }
}
