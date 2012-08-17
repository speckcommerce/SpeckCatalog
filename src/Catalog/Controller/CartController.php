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

    public function indexAction()
    {
        return new ViewModel(array(
            'cart' => $this->getCartService()->getSessionCart(),
        ));
    }

    public function getCartService()
    {
        if (!isset($this->cartService)) {
            $this->cartService = $this->getServiceLocator()->get('catalog_cart_service');
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
        $productId = (isset($_POST['product_id']) ? $_POST['product_id'] : $this->params('id'));
        $productBranch = (isset($_POST['product_branch']) ? $_POST['product_branch'] : array());
        $this->getCartService()->addCartItem($productId, $productBranch);
        return $this->_redirect()->toUrl('/cart');
    }

    //todo: move to extending cartservice
    public function updateProductAction()
    {
        $this->getCartService()->replaceCartItemsChildren($_POST['cart_item_id'], $_POST['product_branch']);
        return $this->redirect()->toUrl('/cart');
    }

    //todo : needs to be in service
    public function updateQuantitiesAction()
    {
        $this->getCartService()->updateQuantities($_POST['quantities']);
        return $this->_redirect()->toUrl('/cart');
    }

    public function removeItemAction()
    {
        $cartService = $this->getCartService();
        $cartService->removeItemFromCart($this->params('id'));
        return $this->_redirect()->toUrl('/cart');
    }

}
