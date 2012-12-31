<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class FormServiceTest extends \PHPUnit_Framework_TestCase
{

    public function getService()
    {
        return new \SpeckCatalog\Service\FormService();
    }

    public function testGetFormReturnsForm()
    {
        $service = $this->getService();
        $service->setServiceLocator($this->getMockServiceManager());
        $return = $service->getForm('product');
        $this->assertInstanceOf('\Zend\Form\Form', $return);
    }

    public function testGetFormReturnsFormWithFilter()
    {
        $service = $this->getService();
        $service->setServiceLocator($this->getMockServiceManager());
        $return = $service->getForm('product');
        $this->assertInstanceOf('\Zend\InputFilter\InputFilter', $return->getInputFilter());
    }

    public function testGetFormWithObjectModelBindsObjectModel()
    {
        $service = $this->getService();
        $service->setServiceLocator($this->getMockServiceManager());
        $productModel = new \SpeckCatalog\Model\Product;
        $return = $service->getForm('product', $productModel);
        $this->assertInstanceOf('\SpeckCatalog\Model\AbstractModel', $return->getObject());
    }

    public function testGetFormWithDataArraySetsFormData()
    {
        $service = $this->getService();
        $service->setServiceLocator($this->getMockServiceManager());
        $data = array('name' => 'foo');
        $return = $service->getForm('product', null, $data);
        $return->isValid();//validate so we can pull out the data
        $returnData = $return->getData();
        $this->assertSame($data['name'], $returnData['name']);
    }

    public function testGetKeyFieldsReturnsFieldsMatchingOriginalFieldsInFormObject()
    {
        $service = $this->getService();

        $service->setServiceLocator($this->getMockServiceManager());
        $form = $service->getForm('product');
        $original = $form->getOriginalFields();

        $product = new \SpeckCatalog\Model\Product();
        $service->setServiceLocator($this->getMockServiceManager(true, false));
        $fields = $service->getKeyFields('product', $product);
        $keys = array_keys($fields);

        $this->assertEquals(0, count(array_diff($keys, $original)));
    }

    public function testGetKeyFieldsReturnsArrayOfFieldsAndValues()
    {
        $service = $this->getService();
        $product = new \SpeckCatalog\Model\Product();
        $product->setProductId(99);
        $service->setServiceLocator($this->getMockServiceManager(true,false));
        $fields = $service->getKeyFields('product', $product);

        $this->assertTrue(is_array($fields));
        $this->assertTrue($fields['product_id'] === 99);
    }

    public function getServiceManager()
    {
        return \SpeckCatalogTest\Bootstrap::getServiceManager();
    }

    public function getMockServiceManager($form=true, $filter=true)
    {
        $mockSM = $this->getMock('\Zend\ServiceManager\ServiceLocatorInterface');

        $callNumber = 0;

        if($form) {
            $mockSM->expects($this->at($callNumber))
                ->method('get')
                ->with('speckcatalog_product_form')
                ->will($this->returnValue(new \SpeckCatalog\Form\Product));
            $callNumber++;
        }

        if($filter) {
            $mockSM->expects($this->at($callNumber))
                ->method('get')
                ->with('speckcatalog_product_form_filter')
                ->will($this->returnValue(new \SpeckCatalog\Filter\Product));
            $callNumber++;
        }

        return $mockSM;
    }
}
