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

    //todo : some of this to be moved to a service
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

    //todo : need a service for this
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

    //todo : move this to the service too!
    private function createCartItem($item, $parentOption=null)
    {
        $meta = $this->getServiceLocator()->get('cart_item_meta');

        if ($item->has('images')) {
            $meta->setImage($item->getFirstImage());
        }

        $description = $item->__toString();
        $cartItem = new CartItem();
        $cartItem->setDescription($description);
        $cartItem->setQuantity(1);
        if ($parentOption) {
            $meta->setParentOptionId($parentOption->getOptionId());
            $meta->setParentOptionName($parentOption->__toString());
            $cartItem->setPrice($item->getAddPrice());
        } else {
            $cartItem->setPrice($item->getRecursivePrice());
        }
        $cartItem->setMetaData($meta);

        if($item->has('options')){
            $cartItem = $this->addOptions($item->getOptions(), $cartItem);
        }

        return $cartItem;
    }

    //todo : needs to be in service
    public function updateQuantitiesAction()
    {
        $cartService = $this->getCartService();

        foreach($_POST['quantities'] as $cartItemId => $newQuantity) {
            if(0 === (int) $newQuantity) {
                $cartService->removeItemFromCart($cartItemId);
            } else {
                $item = $cartService->findItemById($cartItemId);
                if (!$item) {
                    throw new \Exception('couldnt find that cart item %n', $cartItemId);
                }
                $item->setQuantity($newQuantity);
                $cartService->persistItem($item);
            }
        }

        return $this->_redirect()->toUrl('/cart');
    }

    public function removeItemAction()
    {
        $cartService = $this->getCartService();
        $cartService->removeItemFromCart($this->params('id'));

        return $this->_redirect()->toUrl('/cart');
    }

}
