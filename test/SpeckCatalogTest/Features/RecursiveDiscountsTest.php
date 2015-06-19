<?php

namespace SpeckCatalogTest\Features;

class RecursiveDiscountsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAdjustmentPrice()
    {
        $choice = new \SpeckCatalog\Model\Choice\Relational();
        $this->assertEquals(0, $choice->getAdjustmentPrice(0));

        $choice->setPriceDiscountFixed(100);
        $this->assertEquals(-100, $choice->getAdjustmentPrice(100));

        $choice->setPriceDiscountFixed(null);
        $choice->setPriceDiscountPercent(10);
        $this->assertEquals(-10, $choice->getAdjustmentPrice(100));

        $choice->setPriceDiscountPercent(null);
        $choice->setPriceOverrideFixed(300);
        $this->assertEquals(200, $choice->getAdjustmentPrice(100));

        $choice->setPriceOverrideFixed(null);
        $choice->setPriceNoCharge(1);
        $this->assertEquals(-100, $choice->getAdjustmentPrice(100));
    }


    public function testGetRecursivePriceWithProduct()
    {
        $choice = new \SpeckCatalog\Model\Choice\Relational();

        $product = $this->getMockBuilder('\SpeckCatalog\Model\Product\Relational')->getMock();
        $product->expects($this->atLeastOnce())
                ->method('getRecursivePrice')
                ->will($this->returnValue(1000));

        $choice->setProduct($product);

        $this->assertEquals(1000, $choice->getRecursivePrice(1001));

        $choice->setPriceDiscountFixed(200);
        $this->assertEquals(800, $choice->getRecursivePrice(1001));

        $choice->setPriceDiscountFixed(null);
        $choice->setPriceDiscountPercent(10);
        $this->assertEquals(900, $choice->getRecursivePrice(1001));

        $choice->setPriceDiscountPercent(null);
        $choice->setPriceOverrideFixed(800);
        $this->assertEquals(800, $choice->getRecursivePrice(1001));

        $choice->setPriceOverrideFixed(null);
        $choice->setPriceNoCharge(1);
        $this->assertEquals(0, $choice->getRecursivePrice(1001));
    }


    public function testGetRecursivePriceWithOptions()
    {
        $choice = new \SpeckCatalog\Model\Choice\Relational();
        $option = new \SpeckCatalog\Model\Option\Relational();
        $option->setRequired(true);

        $nestedChoice = new \SpeckCatalog\Model\Choice\Relational();

        $optionMock = $this->getMockBuilder('\SpeckCatalog\Model\Option\Relational')->getMock();
        $optionMock->expects($this->atLeastOnce())
                    ->method('getAdjustedPrice')
                    ->will($this->returnValue(1000));

        $choice->setParent($optionMock);
        $option->addChoice($nestedChoice);
        $choice->addOption($option);

        $this->assertEquals(0, $choice->getRecursivePrice(1000));

        $choice->setPriceDiscountFixed(100);
        $this->assertEquals(-100, $choice->getRecursivePrice(1000));

        $choice->setPriceDiscountFixed(null);
        $nestedChoice->setPriceDiscountFixed(100);
        $this->assertEquals(-100, $choice->getRecursivePrice(1000));


        $nestedChoice->setPriceDiscountFixed(null);
        $nestedChoice->setPriceDiscountPercent(10);
        $this->assertEquals(-100, $choice->getRecursivePrice(1000));


        $nestedChoice->setPriceDiscountPercent(null);
        $nestedChoice->setPriceOverrideFixed(500);
        $this->assertEquals(-500, $choice->getRecursivePrice(1000));


        $nestedChoice->setPriceOverrideFixed(null);
        $nestedChoice->setPriceNoCharge(1);
        $this->assertEquals(-1000, $choice->getRecursivePrice(1000));
    }


    public function testGetRecursivePriceWithMultipleNestedOptions()
    {
        $choice = new \SpeckCatalog\Model\Choice\Relational();

        $option = new \SpeckCatalog\Model\Option\Relational();
        $option->setRequired(true);

        $option1 = new \SpeckCatalog\Model\Option\Relational();
        $option1->setRequired(true);

        $nestedChoice = new \SpeckCatalog\Model\Choice\Relational();
        $nestedChoice1 = new \SpeckCatalog\Model\Choice\Relational();

        $optionMock = $this->getMockBuilder('\SpeckCatalog\Model\Option\Relational')->getMock();
        $optionMock->expects($this->any())
                   ->method('getAdjustedPrice')
                   ->will($this->returnValue(1000));

        $choice->setParent($optionMock);
        $option->addChoice($nestedChoice);
        $option1->addChoice($nestedChoice1);
        $choice->addOption($option);
        $choice->addOption($option1);

        $this->assertEquals(0, $choice->getRecursivePrice(1000));

        $nestedChoice->setPriceDiscountFixed(100);
        $nestedChoice1->setPriceDiscountFixed(101);
        $this->assertEquals(-201, $choice->getRecursivePrice(1000));

        $nestedChoice->setPriceDiscountFixed(null);
        $nestedChoice->setPriceDiscountPercent(10);
        $this->assertEquals(-201, $choice->getRecursivePrice(1000));


        $nestedChoice->setPriceDiscountPercent(null);
        $nestedChoice->setPriceOverrideFixed(50);
        $this->assertEquals(-1000, $choice->getRecursivePrice(1000));


        $nestedChoice->setPriceOverrideFixed(null);
        $nestedChoice->setPriceNoCharge(1);
        $this->assertEquals(-1000, $choice->getRecursivePrice(1000));


        $nestedChoice1->setPriceDiscountFixed(null);
        $nestedChoice1->setPriceNoCharge(1);
        $nestedChoice->setPriceNoCharge(1);
        $this->assertEquals(-1000, $choice->getRecursivePrice(1000));
    }


    public function testGetRecursivePriceWithMultipleNestedChoices()
    {
        $choice = new \SpeckCatalog\Model\Choice\Relational();

        $option = new \SpeckCatalog\Model\Option\Relational();
        $option->setRequired(true);

        $nestedChoice = new \SpeckCatalog\Model\Choice\Relational();
        $nestedChoice1 = new \SpeckCatalog\Model\Choice\Relational();

        $optionMock = $this->getMockBuilder('\SpeckCatalog\Model\Option\Relational')->getMock();
        $optionMock->expects($this->any())
                   ->method('getAdjustedPrice')
                   ->will($this->returnValue(1000));

        $choice->setParent($optionMock);
        $option->addChoice($nestedChoice);
        $option->addChoice($nestedChoice1);
        $choice->addOption($option);

        $this->assertEquals(0, $choice->getRecursivePrice(1000));

        $nestedChoice->setPriceDiscountFixed(100);
        $nestedChoice1->setPriceDiscountFixed(101);
        $this->assertEquals(-101, $choice->getRecursivePrice(1000));

        $nestedChoice->setPriceDiscountFixed(null);
        $nestedChoice->setPriceDiscountPercent(10);
        $this->assertEquals(-101, $choice->getRecursivePrice(1000));


        $nestedChoice->setPriceDiscountPercent(null);
        $nestedChoice->setPriceOverrideFixed(50);
        $this->assertEquals(-950, $choice->getRecursivePrice(1000));

        $nestedChoice->setPriceOverrideFixed(null);
        $nestedChoice->setPriceNoCharge(1);
        $this->assertEquals(-1000, $choice->getRecursivePrice(1000));

        $nestedChoice1->setPriceDiscountFixed(null);
        $nestedChoice1->setPriceNoCharge(1);
        $nestedChoice->setPriceNoCharge(1);
        $this->assertEquals(-1000, $choice->getRecursivePrice(1000));
    }
}
