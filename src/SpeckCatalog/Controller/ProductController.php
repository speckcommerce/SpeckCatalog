<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractActionController
{
    protected $catalogService;
    protected $modelLinkerService;
    protected $builderService;

    public function indexAction()
    {
        $cartItemId     = $this->params('cartItemId');
        $cartService    = $this->getServiceLocator()->get('speckcatalog_cart_service');
        $productService = $this->getServiceLocator()->get('speckcatalog_product_service');
        $product        = $productService->getFullProduct($this->params('id')); //, true, true);
        if(!$product){
            throw new \Exception('no product for that id');
        }
        $vars = array(
            'product'     => $product,
            'editingCart' => ($cartItemId ? true : false),
            'cartItem'    => ($cartItemId ? $cartService->findItemById($cartItemId) : false),
        );
        if ($product->has('builders')) {
            $vars['builders'] = $this->getBuilderService()->buildersToProductCsv($product->getBuilders());
        }
        return new ViewModel($vars);
    }

    public function uomsPartialAction()
    {
        $postParams = $this->params()->fromPost();
        $productId  = $postParams['product_id'];
        $uomString  = isset($postParams['uom_string']) ? $postParams['uom_string'] : null;
        $quantity   = isset($postParams['quantity'])   ? $postParams['quantity']   : null;

        $html     = '';
        $response = $this->getResponse();

        $service  = $this->getServiceLocator()->get('speckcatalog_product_uom_service');
        $uoms     = $service->getByProductId($productId, true, true);

        if ($uoms) {
            $helperMgr  = $this->getServiceLocator()->get('viewhelpermanager');
            $viewHelper = $helperMgr->get('speckCatalogUomsToCart');
            $html      .= $viewHelper->__invoke($uoms, $uomString, $quantity);
        }

        return $response->setContent($html);
    }

    public function optionsPartialAction()
    {
        $postParams = $this->params()->fromPost();
        $productId  = $postParams['product_id'];

        $service = $this->getServiceLocator()->get('speckcatalog_option_service');
        $options = $service->getByProductId($productId, true, true);

        foreach($options as $option) {
            $vars     = array('option' => $option);
            $renderer = $this->getServiceLocator()->get('zendviewrendererphprenderer');
            $html    .= $renderer->render('/catalog/product/option', $vars);
        }

        return $html;
    }

    /**
     * @return builderService
     */
    public function getBuilderService()
    {
        if (null === $this->builderService) {
            $this->builderService = $this->getServiceLocator()->get('speckcatalog_builder_product_service');
        }
        return $this->builderService;
    }

    /**
     * @param $builderService
     * @return self
     */
    public function setBuilderService($builderService)
    {
        $this->builderService = $builderService;
        return $this;
    }
}
