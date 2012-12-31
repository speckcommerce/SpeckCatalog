<?php

namespace SpeckCatalog\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SpeckCart\Entity\CartItem;

class CatalogCartService implements ServiceLocatorAwareInterface
{
    protected $flatOptions = array();
    protected $productService;
    protected $serviceLocator;
    protected $cartService;
    protected $productUomService;

    public function addCartItem($productId, $flatOptions=array(), $uomString, $quantity)
    {
        $this->flatOptions = $flatOptions;
        $product = $this->getProductService()->getFullProduct($productId, true);
        $cartItem = $this->createCartItem($product, null, $uomString, $quantity);

        $this->getCartService()->addItemToCart($cartItem);
    }

    public function getSessionCart()
    {
        return $this->getCartService()->getSessionCart();
    }

    public function removeItemFromCart($cartItemId)
    {
        return $this->getCartService()->removeItemFromCart($cartItemId);
    }

    public function findItemById($cartItemId)
    {
        //return $this->getCartService()->findItemById($cartItemId);

        //this is temporarly until speck cart service can return an item with its children populated
        $cartItems = $this->getCartService()->getSessionCart()->getItems();
        foreach ($cartItems as $item) {
            if ($cartItemId === $item->getCartItemId()) {
                return $item;
            }
        }
    }

    protected function addOptions($options, $parentCartItem)
    {
        foreach($options as $option){
            if(array_key_exists($option->getOptionId(), $this->flatOptions)){

                $opt = $this->flatOptions[$option->getOptionId()];
                if(is_array($opt)){ // multiple choices allowed(checkboxes or multi-select)
                    foreach($option->getChoices() as $choice){
                        if(array_key_exists($choice->getChoiceId(), $opt)){
                            $childItem = $this->createCartItem($choice, $option);
                            $parentCartItem->addItem($childItem);
                        }
                    }
                } else { // $opt is the choiceId
                    foreach($option->getChoices() as $choice){
                        if($opt == $choice->getChoiceId()){
                            $childItem = $this->createCartItem($choice, $option);
                            $parentCartItem->addItem($childItem);
                        }
                    }
                }

            }
        }
        return $parentCartItem;
    }

    public function replaceCartItemsChildren($cartItemId, $flatOptions)
    {
        $this->flatOptions = $flatOptions;

        $cartItem = $this->findItemById($cartItemId);

        $product = $this->getProductService()->getFullProduct($cartItem->getMetaData()->getProductId());

        //remove all children
        $children = $cartItem->getItems();
        if ($children) {
            foreach ($children as $child) {
                echo 'removed child';
                $this->removeItemFromCart($child->getCartItemId());
            }
        }

        //add the new child items
        $rePopulatedCartItem = $this->addOptions($product->getOptions(), $cartItem);
        $newItems = $rePopulatedCartItem->getItems();
        if ($newItems) {
            foreach ($newItems as $childItem) {
                $childItem->setParentItemId($cartItem->getCartItemId());
                $this->getCartService()->addItemToCart($childItem);
            }
        }

        //update and persist parent
        $cartItem->getMetaData()->setFlatOptions($this->flatOptions);
        $this->getCartService()->persistItem($cartItem);
    }

    /*
     * 'item' is either a product, or a choice
     */
    public function createCartItem($item, $parentOption=null, $uomString=null, $quantity=1)
    {
        $meta = $this->getServiceLocator()->get('cart_item_meta');

        $description = $item->__toString();
        $cartItem = new CartItem();
        $cartItem->setDescription($description);
        $cartItem->setQuantity($quantity);
        if ($parentOption) {
            $meta->setParentOptionId($parentOption->getOptionId());
            $meta->setParentOptionName($parentOption->__toString());
            $cartItem->setPrice($item->getAddPrice());
        } else {
            $meta->setFlatOptions($this->flatOptions);
            $meta->setProductId($item->getProductId());
            $cartItem->setPrice($this->getPriceForUom($uomString));
        }
        if ($uomString) {
            $meta->setUom($uomString);
        }
        $meta->setItemNumber($item->getItemNumber());
        if ($item->has('image')) {
            $meta->setImage($item->getImage());
        }
        $cartItem->setMetaData($meta);

        if($item->has('options')){
            $cartItem = $this->addOptions($item->getOptions(), $cartItem);
        }

        return $cartItem;
    }

    public function getPriceForUom($uomString)
    {
        $exp = explode(':', $uomString);
        $data = array(
            'product_id' => (int) $exp[0],
            'uom_code' => $exp[1],
            'quantity' => (int) $exp[2],
        );
        $uom = $this->getProductUomService()->find($data);
        return $uom->getPrice();
    }

    public function updateQuantities($itemIdToQuantityArray)
    {
        foreach($itemIdToQuantityArray as $cartItemId => $newQuantity)
        {
            if(0 === (int) $newQuantity) {
                $this->getCartservice()->removeItemFromCart($cartItemId);
            } else {
                $item = $this->getCartservice()->findItemById($cartItemId);
                if (!$item) {
                    throw new \Exception('couldnt find that cart item %n', $cartItemId);
                }
                $item->setQuantity($newQuantity);
                $this->getCartservice()->persistItem($item);
            }
        }
    }

    public function getProductService()
    {
        if (null === $this->productService) {
            $this->productService = $this->getServiceLocator()->get('speckcatalog_product_service');
        }
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    function getCartService()
    {
        if (null === $this->cartService) {
            $this->cartService = $this->getServiceLocator()->get('SpeckCart\Service\CartService');
        }
        return $this->cartService;
    }

    function setCartService($cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @return productUomService
     */
    public function getProductUomService()
    {
        if (null === $this->productUomService) {
            $this->productUomService = $this->getServiceLocator()->get('speckcatalog_product_uom_service');
        }
        return $this->productUomService;
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
