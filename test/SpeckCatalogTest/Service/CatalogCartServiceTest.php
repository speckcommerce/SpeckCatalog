<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;
use Mockery;
use SpeckCart\Entity\CartItem;
use SpeckCatalog\Model\CartItemMeta;

class CatalogCartServiceTest extends \PHPUnit_Framework_TestCase
{
    public function getService()
    {
        return new \SpeckCatalog\Service\CatalogCartService();
    }

    public function testAddCartItemGeneratesCartItemWithOptionsAndAddsToCart()
    {
        //$productService = $this->mock('\SpeckCatalog\Service\Product');
        //$cartService = Mockery::mock();
    }

    public function testGetSessionCartReturnsCartModel()
    {
    }

    public function testRemoveItemFromCartRemovesItemFromCart()
    {
    }

    public function asdftestFindItemByIdReturnsCartItemModel()
    {
        $cartItem = new \SpeckCart\Entity\CartItem();
        $cartItem->setCartItemId(123);

        $mockCart = $this->getMock('\SpeckCart\Entity\Cart');
        $mockCart->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue(array($cartItem)));

        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->once())
            ->method('getSessionCart')
            ->will($this->returnValue($mockCart));

        $service = $this->getService();
        $service->setCartService($mockSpeckCartService);

        $return = $service->findItemById(123);
        $this->assertInstanceOf('\SpeckCart\Entity\CartItem', $return);
    }

    public function  asdftestAddOptionsAddsCartItemsToParentCartItemWithSingleChoice()
    {
        $choice = new \SpeckCatalog\Model\Choice\Relational();
        $choice->setChoiceId(33);
        $option = new \SpeckCatalog\Model\Option\Relational();
        $option->setOptionId(22)
            ->setChoices(array($choice));
        $options = array($option);

        $flatOptions = array(22 => 33);
        $service = $this->getService();

        $service->setFlatOptions($flatOptions);

        $cartItem = new \SpeckCart\Entity\CartItem();
        $service->addOptions($options, $cartItem);

        $items = $cartItem->getItems();
        $this->assertTrue(is_array($items));
        $this->assertInstanceOf('\SpeckCart\Entity\CartItem', $items[0]);
    }

    public function asdftestAddOptionsAddsCartItemsToParentCartItemWithMultipleChoices()
    {
        $choice1 = new \SpeckCatalog\Model\Choice\Relational();
        $choice1->setChoiceId(33);
        $choice2 = new \SpeckCatalog\Model\Choice\Relational();
        $choice2->setChoiceId(44);
        $option = new \SpeckCatalog\Model\Option\Relational();
        $option->setOptionId(22)
            ->setChoices(array($choice1, $choice2));
        $options = array($option);

        $flatOptions = array(22 => array(33 => 33, 44 => 44));
        $service = $this->getService();

        $service->setFlatOptions($flatOptions);

        $cartItem = new \SpeckCart\Entity\CartItem();
        $service->addOptions($options, $cartItem);

        $items = $cartItem->getItems();
        $this->assertTrue(is_array($items));
        $this->assertEquals(2, count($items));
        $this->assertInstanceOf('\SpeckCart\Entity\CartItem', $items[0]);
    }

    public function testReplaceCartItemsChildrenReplacesAllChildCartItemsWithNewItemsBuiltFromFlatOptions()
    {
        $flatOptions = array(22 => 33);

        $cartItem = $this->getMock('\SpeckCart\Entity\CartItem');
        $cartItem->expects($this->any())
            ->method('getCartItemId')
            ->will($this->returnValue(1));

        $meta = $this->getMock('SpeckCatalog\Model\CartItemMeta');
        $meta->expects($this->any())
            ->method('getProductId')
            ->will($this->returnValue('99'));
        $meta->expects($this->any())
            ->method('setFlatOptions')
            ->with($flatOptions);

        $childCartItem = $this->getMock('\SpeckCart\Entity\CartItem');
        $childCartItem->expects($this->any())
            ->method('getCartItemId')
            ->will($this->returnValue(8));
        $items = array($childCartItem);
        $cartItem->expects($this->any())
            ->method('getItems')
            ->will($this->returnValue($items));
        $cartItem->expects($this->any())
            ->method('getMetadata')
            ->will($this->returnValue($meta));

        $mockCart = $this->getMock('\SpeckCart\Entity\Cart');
        $mockCart->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue(array($cartItem)));

        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->once())
            ->method('getSessionCart')
            ->will($this->returnValue($mockCart));


        //mock for getFullProduct
        $choice1 = new \SpeckCatalog\Model\Choice\Relational();
        $choice1->setChoiceId(33);
        $option = new \SpeckCatalog\Model\Option\Relational();
        $option->setOptionId(22)
            ->setChoices(array($choice1));
        $product = new \SpeckCatalog\Model\Product\Relational();
        $product->setOptions(array($option));
        $mockProductService = $this->getMock('\SpeckCatalog\Service\Product');
        $mockProductService->expects($this->once())
            ->method('getFullProduct')
            ->will($this->returnValue($product));

        $service = $this->getService();
        $service->setCartService($mockSpeckCartService);
        $service->setProductService($mockProductService);

        $mockSpeckCartService->expects($this->once())
            ->method('removeItemFromCart')
            ->with(8);

        $mockSpeckCartService->expects($this->once())
            ->method('addItemToCart');

        $mockSpeckCartService->expects($this->once())
            ->method('persistItem');

        $service->replaceCartItemsChildren(1, $flatOptions);

    }

    public function asdftestCreateCartItemReturnsCartItemModel()
    {
        $service = $this->getService();
        $mockProductUomService = $this->getMockProductUomService();
        $service->setProductUomService($mockProductUomService);

        $testItem = new \SpeckCatalog\Model\Product\Relational();
        $testItem->setName('foo');
        $return = $service->createCartItem($testItem, null, '1:EA:1');
        $this->assertInstanceOf('\SpeckCart\Entity\CartItem', $return);
    }

    public function asdftestCreateCartItemCreatesAndPopulatesMetadataObject()
    {
        $service = $this->getService();
        $mockProductUomService = $this->getMockProductUomService();
        $service->setProductUomService($mockProductUomService);

        $testItem = new \SpeckCatalog\Model\Product\Relational();
        $testItem->setName('foo');
        $return = $service->createCartItem($testItem, null, '1:EA:1');
        $meta = $return->getMetadata();
        $this->assertInstanceOf('\SpeckCatalog\Model\CartItemMeta', $meta);
        $this->assertEquals($meta->getUom(), '1:EA:1');
    }

    public function asdftestGetPriceForUomReturnsPriceForUom()
    {
        $service = $this->getService();
        $mockProductUomService = $this->getMockProductUomService();
        $service->setProductUomService($mockProductUomService);
        $return = $service->getPriceForUom('1:EA:1');
        $this->assertEquals($return, 99);
    }

    public function testUpdateQuantitiesUpdatesQuantitiesOfCartItems()
    {
    }


    public function getMockProductUomService()
    {
        $uom = new \SpeckCatalog\Model\ProductUom();
        $uom->setPrice(99);
        $productUomService = $this->getMock('\SpeckCatalog\Service\ProductUom');
        $productUomService->expects($this->once())
            ->method('find')
            ->will($this->returnValue($uom));
        return $productUomService;
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


    /**
     * @param $productUomService
     * @return self
     */
    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }
}
