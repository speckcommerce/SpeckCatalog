<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBuildersByProductId()
    {
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $builders = array(
            array('choice_id' => 1, 'product_id' => 1),
            array('choice_id' => 4, 'product_id' => 321),
        );
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('getBuildersByProductId')
            ->with(99)
            ->will($this->returnValue($builders));
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $return = $service->getBuildersByProductId(99);
        $this->assertTrue(array_key_exists('321', $return));
    }

    public function testPopulate()
    {
        $choice1 = $this->getMock('\SpeckCatalog\Model\Choice\Relational');
        $choice1->expects($this->atLeastOnce())
            ->method('getPrice')
            ->will($this->returnValue(99));
        $choice2 = $this->getMock('\SpeckCatalog\Model\Choice\Relational');
        $choice2->expects($this->atLeastOnce())
            ->method('getPrice')
            ->will($this->returnValue(88));

        $choices = array($choice1, $choice2);
        $mockChoiceService = $this->getMock('\SpeckCatalog\Service\Choice');
        $mockChoiceService->expects($this->once())
            ->method('getByOptionId')
            ->with(1)
            ->will($this->returnValue($choices));

        $images = array(new \SpeckCatalog\Model\OptionImage);
        $mockImageService = $this->getMock('\SpeckCatalog\Service\Image');
        $mockImageService->expects($this->once())
            ->method('getImages')
            ->with('option', 1)
            ->will($this->returnValue($images));

        $mockOption = $this->getMock('\SpeckCatalog\Model\Option\Relational');
        $mockOption->expects($this->any())
            ->method('getOptionId')
            ->will($this->returnValue(1));
        $mockOption->expects($this->once())
            ->method('setChoices')
            ->with($choices)
            ->will($this->returnValue($mockOption));
        $mockOption->expects($this->once())
            ->method('setImages')
            ->with($images)
            ->will($this->returnValue($mockOption));

        $service = $this->getService()
            ->setChoiceService($mockChoiceService)
            ->setImageService($mockImageService);

        $service->populate($mockOption);
    }

    public function testGetByProductIdCallsGetByProductIdOnMapper()
    {
        $option = new \SpeckCatalog\Model\Option\Relational;
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('getByProductId')
            ->with(1)
            ->will($this->returnValue(array($option)));
        $service = $this->getMock('\SpeckCatalog\Service\Option', array('populate'));
        $service->expects($this->atLeastOnce())
            ->method('populate')
            ->with($option)
            ->will($this->returnValue($option));
        $service->setEntityMapper($mockMapper);
        $return = $service->getByProductId(1, true);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\Option', $return[0]);
    }

    public function testGetByParentChoiceIdCallsGetByParentChoiceIdOnMapperAndPopulates()
    {
        $option = new \SpeckCatalog\Model\Option\Relational;
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('getByParentChoiceId')
            ->with(1)
            ->will($this->returnValue(array($option)));

        $service = $this->getMock('\SpeckCatalog\Service\Option', array('populate'));
        $service->expects($this->atLeastOnce())
            ->method('populate')
            ->with($option)
            ->will($this->returnValue($option));

        $service->setEntityMapper($mockMapper);
        $return = $service->getByParentChoiceId(1, true);
        $this->assertTrue(is_array($return));
        $this->assertInstanceOf('\SpeckCatalog\Model\Option', $return[0]);
    }

    public function testInsertOptionWithArrayFetchesParentProductModelAndSetsParentThenReturns()
    {
        $option = array('product_id' => 1);

        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('insert')
            ->will($this->returnValue(new \SpeckCatalog\Model\Option\Relational));
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $serviceManager = $this->getMockServiceManager(array(
            'speckcatalog_product_service' => $this->getMockProductService(),
        ));
        $service->setServiceLocator($serviceManager);
        $return = $service->insert($option);
        $this->assertInstanceOf('\SpeckCatalog\Model\Product', $return->getParent());
    }

    public function testInsertOptionWithModelFetchesParentChoiceModelAndSetsParentThenReturns()
    {
        $option = new \SpeckCatalog\Model\Option\Relational;
        $option->setChoiceId(1);

        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('insert')
            ->will($this->returnValue(new \SpeckCatalog\Model\Option\Relational));
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $serviceManager = $this->getMockServiceManager(array(
            'speckcatalog_choice_service' => $this->getMockChoiceService(),
        ));
        $service->setServiceLocator($serviceManager);
        $return = $service->insert($option);
        $this->assertInstanceOf('\SpeckCatalog\Model\Choice', $return->getParent());
    }

    public function getMockChoiceService()
    {
        $mock = $this->getMock('\SpeckCatalog\Service\Choice');
        $mock->expects($this->any())
            ->method('find')
            ->with(array('choice_id' => 1))
            ->will($this->returnValue(new \SpeckCatalog\Model\Choice));
        return $mock;
    }

    public function getMockProductService()
    {
        $mock = $this->getMock('\SpeckCatalog\Service\Product');
        $mock->expects($this->any())
            ->method('find')
            ->with(array('product_id' => 1))
            ->will($this->returnValue(new \SpeckCatalog\Model\Product));
        return $mock;
    }

    public function getMockServiceManager(array $items = array())
    {
        $mockSM = $this->getMock('\Zend\ServiceManager\ServiceLocatorInterface');

        $callNumber = 0;

        foreach ($items as $name => $return) {
            $mockSM->expects($this->at($callNumber))
                ->method('get')
                ->with($name)
                ->will($this->returnValue($return));
            $callNumber++;
        }

        return $mockSM;
    }

    public function testUpdateWithModelGeneratesOriginalValuesAndCallsUpdateOnMapper()
    {
        $option = new \SpeckCatalog\Model\Option;
        $option->setOptionId(1);
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('update')
            ->with($option, array('option_id' => 1))
            ->will($this->returnValue($option));
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->update($option);
    }

    public function testUpdateWithArrayGeneratesOriginalValuesAndCallsUpdateOnMapper()
    {
        $option = array('option_id' => 1);
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('update')
            ->with($option, array('option_id' => 1))
            ->will($this->returnValue($option));
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->update($option);
    }

    public function testGetChoiceService()
    {
        $choiceService = new \SpeckCatalog\Service\Choice;
        $service = $this->getService();
        $service->setChoiceService($choiceService);
        $return = $service->getChoiceService();
        $this->assertInstanceOf('\SpeckCatalog\Service\Choice', $return);
    }

    public function testGetImageService()
    {
        $imageService = new \SpeckCatalog\Service\Image;
        $service = $this->getService();
        $service->setImageService($imageService);
        $this->assertInstanceOf('\SpeckCatalog\Service\Image', $service->getImageService());
    }

    public function testGetImageServiceFromServiceManager()
    {
        $config = array('speckcatalog_option_image_service' => new \SpeckCatalog\Service\Image);
        $mockServiceManager = $this->getMockServiceManager($config);
        $service = $this->getService();
        $service->setServiceLocator($mockServiceManager);
        $service->getImageService();
    }

    public function testGetProductService()
    {
        $productService = new \SpeckCatalog\Service\Product;
        $service = $this->getService();
        $service->setProductService($productService);
        $this->assertInstanceOf('\SpeckCatalog\Service\Product', $service->getProductService());
    }

    public function testSortChoicesCallsSortChoicesOnMapper()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Option');
        $mockMapper->expects($this->once())
            ->method('sortChoices')
            ->with(1, array(1,2));
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->sortChoices(1, array(1,2));
    }

    public function testRemoveChoiceWithModelCallsDeleteOnMapper()
    {
        $mockChoiceService = $this->getMock('\SpeckCatalog\Service\Choice');
        $mockChoiceService->expects($this->once())
            ->method('delete')
            ->with(1);
        $service = $this->getService();
        $service->setChoiceService($mockChoiceService);

        $choice = new \SpeckCatalog\Model\Choice;
        $choice->setChoiceId(1);
        $service->removeChoice($choice);
    }

    public function testRemoveChoiceWithIdCallsDeleteOnMapper()
    {
        $mockChoiceService = $this->getMock('\SpeckCatalog\Service\Choice');
        $mockChoiceService->expects($this->once())
            ->method('delete')
            ->with(1);
        $service = $this->getService();
        $service->setChoiceService($mockChoiceService);

        $service->removeChoice(1);
    }

    public function getService()
    {
        return new \SpeckCatalog\Service\Option;
    }
}
