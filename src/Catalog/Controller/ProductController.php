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
        $cartItemId = $this->params('cartItemId');
        $cartService = $this->getServiceLocator()->get('catalog_cart_service');
        $productService = $this->getServiceLocator()->get('catalog_product_service');
        $product = $productService->getById($this->params('id'), true, true);
        if(!$product){
            throw new \Exception('fore oh fore');
        }
        return new ViewModel(array(
            'product'     => $product,
            'editingCart' => ($cartItemId ? true : false),
            'cartItem'    => ($cartItemId ? $cartService->findItemById($cartItemId) : false),
        ));
    }
}
