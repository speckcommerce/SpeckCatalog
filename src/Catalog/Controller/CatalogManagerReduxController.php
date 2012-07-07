<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Exception;

class CatalogManagerReduxController extends AbstractActionController
{
    protected $catalogService;

    protected $partialDir = 'catalog/catalog-manager-redux/partial/';

    public function indexAction()
    {
        return new ViewModel();
    }

    public function productAction()
    {
        $product = $this->getCatalogService()->getById('product', $this->params('id'));
        $view = new ViewModel(array('product' => $product));
        return $view;
    }


    /**
     * Get catalogService.
     *
     * @return catalogService.
     */
    public function getCatalogService()
    {
        if(null === $this->catalogService){
            $this->catalogService = $this->getServiceLocator()->get('catalog_generic_service');
        }
        return $this->catalogService;
    }

    /**
     * Set catalogService.
     *
     * @param catalogService the value to set.
     */
    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }
}
