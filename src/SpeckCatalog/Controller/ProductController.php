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
        return new ViewModel(array(
            'product'     => $product,
            'editingCart' => ($cartItemId ? true : false),
            'cartItem'    => ($cartItemId ? $cartService->findItemById($cartItemId) : false),
        ));
    }

    public function uomsPartialAction()
    {
        $postParams = $this->params()->fromPost();
        $productId = $postParams['product_id'];
        $uomString = isset($postParams['uom_string']) ? $postParams['uom_string'] : null;
        $quantity = isset($postParams['quantity']) ? $postParams['quantity'] : null;

        $productUomService = $this->getServiceLocator()->get('speckcatalog_product_uom_service');
        $uoms = $productUomService->getByProductId($productId, true, true);

        $viewHelperManager = $this->getServiceLocator()->get('viewhelpermanager');
        $viewHelper = $viewHelperManager->get('speckCatalogUomsToCart');

        $html = $viewHelper->__invoke($uoms, $uomString, $quantity);
        $response = $this->getResponse()->setContent($html);
        return $response;
    }
}
