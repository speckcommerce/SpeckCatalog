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
        $product = new \SpeckCatalog\Model\Product\Relational();
        $mockProductService = $this->getMock('\SpeckCatalog\Service\Product');
        $mockProductService->expects($this->any())
            ->method('getFullProduct')
            ->will($this->returnValue($product));

        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->once())
            ->method('addItemToCart');

        $service = $this->getService();
        $service->setProductService($mockProductService);
        $service->setCartService($mockSpeckCartService);
        $service->setProductUomService($this->getMockProductUomService());

        $service->addCartItem(1, array(), '1:EA:1', 1);
    }

    public function testGetSessionCartCallsGetSessionCartOnSpeckCartService()
    {
        $mockCart = new \SpeckCart\Entity\Cart;
        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->any())
            ->method('getSessionCart')
            ->will($this->returnValue($mockCart));

        $service = $this->getService();
        $service->setCartService($mockSpeckCartService);
        $cart = $service->getSessionCart();
        $this->assertInstanceOf('\SpeckCart\Entity\Cart', $cart);
    }

    public function testRemoveItemFromCartCallsRemoveItemFromCartOnSpeckCartService()
    {
        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->once())
            ->method('removeItemFromCart')
            ->with(99);
        $service = $this->getService();
        $service->setCartService($mockSpeckCartService);

        $service->removeItemFromCart(99);
    }

    public function testFindItemByIdReturnsCartItemModel()
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

    public function testAddOptionsAddsCartItemsToParentCartItemWithSingleChoice()
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

    public function testAddOptionsAddsCartItemsToParentCartItemWithMultipleChoices()
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
        $mockCart->expects($this->any())
            ->method('getItems')
            ->will($this->returnValue(array($cartItem)));

        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->once())
            ->method('getSessionCart')
            ->will($this->returnValue($mockCart));

        $choice1 = new \SpeckCatalog\Model\Choice\Relational();
        $choice1->setChoiceId(33);
        $option = new \SpeckCatalog\Model\Option\Relational();
        $option->setOptionId(22)
            ->setChoices(array($choice1));
        $product = new \SpeckCatalog\Model\Product\Relational();
        $product->setOptions(array($option));
        $mockProductService = $this->getMock('\SpeckCatalog\Service\Product');
        $mockProductService->expects($this->any())
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

    public function testCreateCartItemReturnsCartItemModel()
    {
        $service = $this->getService();
        $mockProductUomService = $this->getMockProductUomService();
        $service->setProductUomService($mockProductUomService);

        $testItem = new \SpeckCatalog\Model\Product\Relational();
        $testItem->setName('foo');
        $return = $service->createCartItem($testItem, null, '1:EA:1');
        $this->assertInstanceOf('\SpeckCart\Entity\CartItem', $return);
    }

    public function testCreateCartItemCreatesAndPopulatesMetadataObject()
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

    public function testGetPriceForUomReturnsPriceForUom()
    {
        $service = $this->getService();
        $mockProductUomService = $this->getMockProductUomService();
        $service->setProductUomService($mockProductUomService);
        $return = $service->getPriceForUom('1:EA:1');
        $this->assertEquals($return, 99);
    }

    public function testUpdateQuantitiesUpdatesQuantitiesOfCartItems()
    {
        $mockItem = $this->getMock('\SpeckCart\Entity\CartItem');
        $mockItem->expects($this->once())
            ->method('setQuantity')
            ->with('88')
            ->will($this->returnValue($mockItem));
        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->any())
            ->method('findItemById')
            ->will($this->returnValue($mockItem));
        $mockSpeckCartService->expects($this->once())
            ->method('persistItem');

        $service = $this->getService();
        $service->setCartService($mockSpeckCartService);
        $service->updateQuantities(array(1 => 88));
    }

    public function testUpdateQuantitiesRemovesItemWhenNewQuantityIsZero()
    {
        $mockItem = $this->getMock('\SpeckCart\Entity\CartItem');
        $mockSpeckCartService = $this->getMock('\SpeckCart\Service\CartService');
        $mockSpeckCartService->expects($this->any())
            ->method('findItemById')
            ->will($this->returnValue($mockItem));
        $mockSpeckCartService->expects($this->once())
            ->method('removeItemFromCart')
            ->with('321');

        $service = $this->getService();
        $service->setCartService($mockSpeckCartService);
        $service->updateQuantities(array(321 => 0));
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

    public function testGetProductService()
    {
        $productService = new \SpeckCatalog\Service\Product;
        $service = $this->getService();
        $service->setProductService($productService);
        $this->assertInstanceOf('\SpeckCatalog\Service\Product', $service->getProductService());
    }

    public function testGetProductServiceFromServiceManager()
    {
        $config = array('speckcatalog_product_service' => new \SpeckCatalog\Service\Product);
        $mockServiceManager = $this->getMockServiceManager($config);
        $service = $this->getService();
        $service->setServiceLocator($mockServiceManager);
        $service->getProductService();
    }

    public function testGetProductUomService()
    {
        $productUomService = new \SpeckCatalog\Service\ProductUom;
        $service = $this->getService();
        $service->setProductUomService($productUomService);
        $this->assertInstanceOf('\SpeckCatalog\Service\ProductUom', $service->getProductUomService());
    }

    public function testGetProductUomServiceFromServiceManager()
    {
        $config = array('speckcatalog_product_uom_service' => new \SpeckCatalog\Service\ProductUom);
        $mockServiceManager = $this->getMockServiceManager($config);
        $service = $this->getService();
        $service->setServiceLocator($mockServiceManager);
        $service->getProductUomService();
    }

    public function testGetFlatOptions()
    {
        $service = $this->getService();
        $test = array(1 => 3);
        $service->setFlatOptions($test);
        $return = $service->getFlatOptions();
        $this->assertSame($test, $return);
    }

    public function testGetCartService()
    {
        $cartService = new \SpeckCart\Service\CartService;
        $service = $this->getService();
        $service->setCartService($cartService);
        $this->assertInstanceOf('\SpeckCart\Service\CartService', $service->getCartService());
    }

    public function testGetCartServiceFromServiceManager()
    {
        $config = array('SpeckCart\Service\CartService' => new \SpeckCart\Service\CartService);
        $mockServiceManager = $this->getMockServiceManager($config);
        $service = $this->getService();
        $service->setServiceLocator($mockServiceManager);
        $service->getCartService();
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
