<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CatalogController extends AbstractActionController
{
    public function indexAction()
    {
        $categories = $this->getServiceLocator()->get('speckcatalog_category_service')->getCategoriesForNavigation();
        return new ViewModel(array('categories' => $categories));
    }

    public function productRedirectAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        return $this->redirect()->toRoute('product/byid', array('id' => $id));
    }
}
