<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;
use Mockery;

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

    public function testFindItemByIdReturnsCartItemModel()
    {
    }

    public function testAddOptionsAddsCartItemsToParentCartItem()
    {
    }

    public function testReplaceCartItemsChildrenReplacesAllChildCartItemsWithNewItemsBuiltFromFlatOptions()
    {
    }

    public function testCreateCartItemReturnsCartItemModel()
    {
        $service = $this->getService();
        $sm = array('cart_item_meta' => new \SpeckCatalog\Model\CartItemMeta);
        $service->setServiceLocator($this->getMockServiceManager($sm));

        //mock up productuom service so getPriceForUom works
        $uom = new \SpeckCatalog\Model\ProductUom();
        $uom->setPrice(99);
        $productUomService = $this->getMock('\SpeckCatalog\Service\ProductUom');
        $productUomService->expects($this->once())
            ->method('find')
            ->will($this->returnValue($uom));
        $service->setProductUomService($productUomService);

        $testItem = new \SpeckCatalog\Model\Product();
        $testItem->setName('foo');
        $return = $service->createCartItem($testItem, null, '1:EA:1');
        $this->assertInstanceOf('\SpeckCart\Entity\CartItem', $return);
    }

    public function testCreateCartItemCreatesAndPopulatesMetadataObject()
    {
    }

    public function testGetPriceForUomReturnsPriceForUom()
    {
    }

    public function testUpdateQuantitiesUpdatesQuantitiesOfCartItems()
    {
    }


    public function getMockServiceManager(array $items)
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

}
