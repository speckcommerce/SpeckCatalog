<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SpeckCart\Entity\CartItem;
use Zend\View\Model\ViewModel;

class CartController extends AbstractActionController
{
    protected $cartService;
    protected $productService;
    protected $choiceService;

    public function init()
    {
        $this->cartService = $this->getServiceLocator()->get('SpeckCart\Service\CartService');
        $this->productService = $this->getServiceLocator()->get('catalog_product_service');
        $this->choiceService = $this->getServiceLocator()->get('catalog_choice_service');
    }

    public function indexAction()
    {
        $cs = $this->getCartService();
        $cart = $cs->getSessionCart();

        return new ViewModel(array(
            'cart' => $cart
        ));
    }

    public function getCartService()
    {
        if (!isset($this->cartService)) {
            $this->cartService = $this->getServiceLocator()->get('SpeckCart\Service\CartService');
        }

        return $this->cartService;
    }

    public function setCartService($service)
    {
        $this->cartService = $service;
        return $this;
    }

    public function addItemAction()
    {
        $this->init();

        $product = $this->productService->getById($_POST['product_id']);
        $arr = array(
            'description' => $product->getName(),
            'quantity' => $_POST['quantity'],
        );
        $cartItem = $this->createCartItem($arr);
        $this->cartService->addItemToCart($cartItem);

        if(isset($_POST['product_branch'])){
            $this->addChildrenToCart($_POST['product_branch'], $cartItem->getCartItemId());
        }
        echo '<a href="/cart">your cart</a>';
    }

    public function addChildrenToCart($children, $parentId)
    {
        foreach($children as $i => $choiceId){
            $choice = $this->choiceService->getById($choiceId);

            $arr = array(
                'description' => $choice->__toString(),
                'quantity' => 1,
            );
            $cartItem = $this->createCartItem($arr)->setParentItemId($parentId);
            $this->cartService->addItemToCart($cartItem);
        }

    }

    public function createCartItem($arr)
    {
        $cartItem = new CartItem();
        $cartItem->setDescription($arr['description']);
        $cartItem->setQuantity($arr['quantity']);
        $cartItem->setPrice(99.99);
        return $cartItem;
    }


}
