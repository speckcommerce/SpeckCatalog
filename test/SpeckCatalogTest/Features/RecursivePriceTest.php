<?php

namespace SpeckCatalogTest\Features;


class RecursivePriceTest extends \PHPUnit_Framework_TestCase
{
	public function testGetAddPrice()
	{
		$product = $this->getMockBuilder('\SpeckCatalog\Model\Product\Relational')->getMock();
		$product->expects($this->atLeastOnce())
		        ->method('getPrice')
		        ->will($this->returnValue(1000));

		$option = new \SpeckCatalog\Model\Option\Relational();
		$option->setParent($product);

		$choice = new \SpeckCatalog\Model\Choice\Relational();
		$option->addChoice($choice);


		$this->assertEquals(0, $choice->getAddPrice());

		$choice1 = new \SpeckCatalog\Model\Choice\Relational();
		$option->addChoice($choice1);

		$this->assertEquals(0, $choice1->getAddPrice());

		$choice->setPriceDiscountFixed(100);
		$this->assertEquals(-100, $choice->getAddPrice());

		$choice1->setPriceDiscountFixed(10);
		$this->assertEquals(-100, $choice->getAddPrice());
		$this->assertEquals(-10, $choice1->getAddPrice());

		$choice1->setPriceDiscountFixed(null);
		$choice1->setPriceDiscountPercent(12);
		$this->assertEquals(-100, $choice->getAddPrice());
		$this->assertEquals(-120, $choice1->getAddPrice());

		$choice1->setPriceDiscountPercent(null);
		$choice1->setPriceOverrideFixed(245);
		$this->assertEquals(-100, $choice->getAddPrice());
		$this->assertEquals(-755, $choice1->getAddPrice());

		$choice1->setPriceOverrideFixed(null);
		$choice1->setPriceNoCharge(1);
		$this->assertEquals(-100, $choice->getAddPrice());
		$this->assertEquals(-1000, $choice1->getAddPrice());
	}


	public function testGetAddPriceWithProduct()
	{
		$product = $this->getMockBuilder('\SpeckCatalog\Model\Product\Relational')->getMock();
		$product->expects($this->atLeastOnce())
		        ->method('getPrice')
                ->will($this->returnValue(1000));

		$product1 = $this->getMockBuilder('\SpeckCatalog\Model\Product\Relational')->getMock();
		$product1->expects($this->atLeastOnce())
		         ->method('getPrice')
                 ->will($this->returnValue(500));

		$option = new \SpeckCatalog\Model\Option\Relational();
		$option->setParent($product);

		$choice = new \SpeckCatalog\Model\Choice\Relational();
		$option->addChoice($choice);

		$choice1 = new \SpeckCatalog\Model\Choice\Relational();
		$choice1->setProduct($product1);
		$option->addChoice($choice1);

		$this->assertEquals(0, $choice->getAddPrice());
		$this->assertEquals(500, $choice1->getAddPrice());

		$choice1->setPriceDiscountFixed(45);
		$this->assertEquals(0, $choice->getAddPrice());
		$this->assertEquals(455, $choice1->getAddPrice());

		$choice1->setPriceDiscountFixed(null);
		$choice1->setPriceDiscountPercent(15);
		$this->assertEquals(0, $choice->getAddPrice());
		$this->assertEquals(425, $choice1->getAddPrice());


		$choice1->setPriceDiscountPercent(null);
		$choice1->setPriceOverrideFixed(125);
		$this->assertEquals(0, $choice->getAddPrice());
		$this->assertEquals(125, $choice1->getAddPrice());

		$choice1->setPriceOverrideFixed(null);
		$choice1->setPriceNoCharge(1);
		$this->assertEquals(0, $choice->getAddPrice());
		$this->assertEquals(0, $choice1->getAddPrice());

		$choice1->setPriceNoCharge(0);
		$choice1->setPriceDiscountPercent(15);
		$choice->setPriceDiscountFixed(25);
		$this->assertEquals(-25, $choice->getAddPrice());
		$this->assertEquals(425, $choice1->getAddPrice());
	}



	public function testGetAddPriceWithNestedOptions()
	{
		$product = $this->getMockBuilder('\SpeckCatalog\Model\Product\Relational')->getMock();
		$product->expects($this->any())
		        ->method('getPrice')
		        ->will($this->returnValue(1000));

		$product1 = $this->getMockBuilder('\SpeckCatalog\Model\Product\Relational')->getMock();
		$product1->expects($this->any())
		         ->method('getPrice')
		         ->will($this->returnValue(500));

		$option = new \SpeckCatalog\Model\Option\Relational();
		$option->setParent($product);

		$choice = new \SpeckCatalog\Model\Choice\Relational();
		$option->addChoice($choice);

		$choice1 = new \SpeckCatalog\Model\Choice\Relational();
		$choice1->setProduct($product1);
		$option->addChoice($choice1);

		$choice2 = new \SpeckCatalog\Model\Choice\Relational();
		$option1 = new \SpeckCatalog\Model\Option\Relational();
		$option1->addChoice($choice2);
		$choice->addOption($option1);

		$this->assertEquals(0, $choice2->getAddPrice());
		$this->assertEquals(500, $choice1->getAddPrice());
		$this->assertEquals(0, $choice->getAddPrice());

		$choice2->setPriceDiscountFixed(100);
		$this->assertEquals(-100, $choice2->getAddPrice());
		$this->assertEquals(500, $choice1->getAddPrice());
		$this->assertEquals(0, $choice->getAddPrice());

		$choice1->setPriceDiscountFixed(100);
		$this->assertEquals(-100, $choice2->getAddPrice());
		$this->assertEquals(400, $choice1->getAddPrice());
		$this->assertEquals(0, $choice->getAddPrice());

		$choice->setPriceDiscountFixed(100);
		$this->assertEquals(-100, $choice2->getAddPrice());
		$this->assertEquals(400, $choice1->getAddPrice());
		$this->assertEquals(-100, $choice->getAddPrice());

		$choice->setPriceDiscountFixed(null);
		$choice1->setPriceDiscountFixed(null);
		$choice2->setPriceDiscountFixed(null);

		$choice->setPriceDiscountPercent(10);
		$this->assertEquals(-100, $choice->getAddPrice());
		$this->assertEquals(500, $choice1->getAddPrice());
		$this->assertEquals(0, $choice2->getAddPrice());

		$choice1->setPriceDiscountPercent(15);
		$this->assertEquals(-100, $choice->getAddPrice());
		$this->assertEquals(425, $choice1->getAddPrice());
		$this->assertEquals(0, $choice2->getAddPrice());


		$choice2->setPriceDiscountPercent(20);
		$this->assertEquals(-100, $choice->getAddPrice());
		$this->assertEquals(425, $choice1->getAddPrice());
		$this->assertEquals(-180, $choice2->getAddPrice());

		$choice->setPriceDiscountPercent(null);
		$choice1->setPriceDiscountPercent(null);
		$choice2->setPriceDiscountPercent(null);

		$choice->setPriceOverrideFixed(950);
		$this->assertEquals(-50, $choice->getAddPrice());
		$this->assertEquals(500, $choice1->getAddPrice());
		$this->assertEquals(0, $choice2->getAddPrice());

		$choice1->setPriceOverrideFixed(425);
		$this->assertEquals(-50, $choice->getAddPrice());
		$this->assertEquals(425, $choice1->getAddPrice());
		$this->assertEquals(0, $choice2->getAddPrice());

		$choice2->setPriceOverrideFixed(800);
		$this->assertEquals(-50, $choice->getAddPrice());
		$this->assertEquals(425, $choice1->getAddPrice());
		$this->assertEquals(-150, $choice2->getAddPrice());

		$choice->setPriceOverrideFixed(null);
		$choice1->setPriceOverrideFixed(null);
		$choice2->setPriceOverrideFixed(null);

		$choice->setPriceNoCharge(1);
		$this->assertEquals(-1000, $choice->getAddPrice());
		$this->assertEquals(500, $choice1->getAddPrice());
		$this->assertEquals(0, $choice2->getAddPrice());

		$choice1->setPriceNoCharge(1);
		$this->assertEquals(-1000, $choice->getAddPrice());
		$this->assertEquals(0, $choice1->getAddPrice());
		$this->assertEquals(0, $choice2->getAddPrice());

		$choice2->setPriceNoCharge(1);
		$this->assertEquals(-1000, $choice->getAddPrice());
		$this->assertEquals(0, $choice1->getAddPrice());
		$this->assertEquals(0, $choice2->getAddPrice());
	}
}
