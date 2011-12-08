<?php

namespace Management\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $factory = new \Management\Service\EntityFactoryService;
        
        $shell = $factory->shellFactory('product');

        $company = new \Management\Entity\Company;
        $company->setName('tiLite');

        $availability = $factory->availabilityFactory();

        $productUom = $factory->productUomFactory(new \Management\Entity\Uom);
        $productUom->addAvailability($availability);

        $product = $factory->productFactory($company)->setName('ProductName')->addUom($productUom);
        $choice = $factory->choiceFactory()->setName('ChoiceName');
        $shell->setProduct($product)->setParentChoices(array($choice, $choice, $choice)); 
        $option1 = $factory->optionFactory('radio');
        $option1->setName('Frame Style');
        $choice1 = $factory->choiceFactory()->setName('Standard Frame');
        $option1->addchoice($choice1)->setSelectedChoice($choice1);
        $shell->setOptions(array($option1, $option1));
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        return array(
            'session' => $this->getLocator()->get('catalog_management_service')->getSession($user),
            'shell' => $shell,
        );
    }
}
