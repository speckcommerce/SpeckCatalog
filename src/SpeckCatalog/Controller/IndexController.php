<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\ActionController,
    Catalog\Entity as Entity;

class IndexController extends ActionController
{
    public function indexAction()
    {
        return array();
        
        $shell = $this->shellFactory('product');

        $company = new Entity\Company;
        $company->setName('tiLite');

        $availability = $this->availabilityFactory();

        $productUom = $this->productUomFactory(new Entity\Uom);
        $productUom->addAvailability($availability);

        $product = $this->productFactory($company);
        $product->setName('name')->addUom($productUom);
        $shell->setProduct($product); 
        $option1 = $this->optionFactory('radio');
        $option1->setName('Frame Style');
        $choice1 = $this->choiceFactory()->setName('Standard Frame');
        $option1->addchoice($choice1)->setSelectedChoice($choice1);
        $shell->addOption($option1);
        
        var_dump($shell); die();
        die();                                                      
    }
}   
