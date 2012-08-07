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
    protected $flatOptions = array();

    public function init()
    {
        $this->cartService = $this->getServiceLocator()->get('SpeckCart\Service\CartService');
        $this->productService = $this->getServiceLocator()->get('catalog_product_service');
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
        $paramId = $this->params('id');
        if (isset($paramId)) {
            $productId = $paramId;
        } elseif (isset($_POST['product_id'])) {
            $productId = $_POST['product_id'];
        } else {
            die('didnt get an id');
        }
        $product = $this->productService->getById($productId, true);
        if(isset($_POST['product_branch'])){
            $this->flatOptions = $_POST['product_branch'];
        }
        $this->cartService->addItemToCart($this->createCartItem($product));
        return $this->_redirect()->toUrl('/cart');
    }

    private function addOptions($options, $parentCartItem)
    {
        foreach($options as $option){
            if(array_key_exists($option->getOptionId(), $this->flatOptions)){

                $opt = $this->flatOptions[$option->getOptionId()];

                if(is_array($opt)){ // multiple choices allowed(checkboxes or multi-select)
                    foreach($option->getChoices() as $choice){
                        if(array_key_exists($choice->getChoiceId(), $opt)){
                            $childItem = $this->createCartItem($choice, $option);
                            $parentCartItem->addItem($childItem);
                        }
                    }
                } else { // $opt is the choiceId
                    foreach($option->getChoices() as $choice){
                        if($opt == $choice->getChoiceId()){
                            $childItem = $this->createCartItem($choice, $option);
                            $parentCartItem->addItem($childItem);
                        }
                    }
                }

            }
        }
        return $parentCartItem;
    }

    private function createCartItem($item, $parentChoice=null)
    {
        if ($parentChoice) {
            $description = '<b>[' . $parentChoice->__toString() . ']</b> ' . $item->__toString();
        } else {
            $description = $item->__toString();
        }

        $cartItem = new CartItem();
        $cartItem->setDescription($description);
        $cartItem->setQuantity(1);
        $cartItem->setPrice($item->getPrice());

        if($item->has('options')){
            $cartItem = $this->addOptions($item->getOptions(), $cartItem);
        }

        return $cartItem;
    }
}
