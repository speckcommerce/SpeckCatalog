<?php
namespace SpeckCatalogManager\Model\Mapper;
use SpeckCatalogManager\Entity;
class SessionMapper
{
    protected $userId;
    protected $entities;

    public function __construct($userId)
    {
      //// test entities
      //$product = new Entity\Product('product');
      //$product->setName('name of a product')->setProductId(3);
      //$product2 = new \SpeckCatalogManager\Entity\Product('product');
      //$product2->setName('name of product2')->setProductId(123);
      //$itemUom = new \SpeckCatalogManager\Entity\ItemUom;
      //$uom = new \SpeckCatalogManager\Entity\Uom;
      //$uom->setName('name of uom!');
      //$itemUom->setUom($uom);
      //$choice = new \SpeckCatalogManager\Entity\Choice;
      //$choice->setName('name of a choice');
      //$choice->setProduct($product2);
      ////$choice->setProduct($product);
      ////$company = new \SpeckCatalogManager\Entity\Company;
      ////$company->setName('companyname!');
      //$option = new \SpeckCatalogManager\Entity\Option('radio');
      //$option->setName('im an option name')
      //    ->setOptionId(99)
      //    ->setChoices(array($choice))
      //    ->setParentProducts(array($product, $product, $product, $product));
      //$item = new \SpeckCatalogManager\Entity\Item;
      //$item->setName('im an item name')->addUom($itemUom);
      //$product->setItem($item)->addOption($option);
      //$product->setParentChoices(array($choice, $choice, $choice));


        $product = new Entity\Product('shell');
        $product->setName('coffee cup')
                ->setProductId(3);
        
        $option = new Entity\Option;
        $option->setOptionId(999)
               ->setName('color')
               ->setInstruction('Choose Color');


        $choice1 = new Entity\Choice;
        $choice1->setChoiceId(122);
        $red = new Entity\Product('product');
        $red->setName('red coffee cup')->setproductId(11);
        $item1 = new Entity\Item;
        $item1->setItemId(88);
        $red->setItem($item1);
        $choice1->setProduct($red)->setOverrideName('red');

        $choice2 = new Entity\Choice;
        $choice2->setChoiceId(123);
        $blue = new Entity\Product('product');
        $blue->setName('blue coffee cup')->setProductId(22);
        $item2 = new Entity\Item;
        $item2->setItemId(99);
        $blue->setItem($item2);
        $choice2->setProduct($blue);//->setOverrideName('blue');

        $option->setChoices(array($choice1, $choice2));

        $product->addOption($option);

        $this->rows = array( 
            'option-'.$option->getOptionId() => $option, 
            'product-'.$product->getProductId() => $product,
        );   

    }

    public function readSessionEntities()
    {
        return $this->rows;
    }
}
