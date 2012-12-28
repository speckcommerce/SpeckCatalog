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

}
