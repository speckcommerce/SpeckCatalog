<?php

namespace Management\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        return array('session' => $this->getLocator()->get('catalog_management_service')->getSession($user));
    }
}
