<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CatalogController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel;
    }

    public function productRedirectAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        return $this->redirect()->toRoute('product', array('id' => $id));
    }
}
