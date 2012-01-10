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

        $product = new Entity\Product('shell');
        $product->setName('coffee cup')
                ->setDescription('this is a mug for your joe, comes in 2 colors')
                ->setProductId(3);
        
        $option = new Entity\Option;
        $option->setOptionId(999)
               ->setName('Color')
               ->setInstruction('Choose Color');


        $choice1 = new Entity\Choice;
        $choice1->setChoiceId(122);
        $red = new Entity\Product('product');
        $red->setName('red coffee cup')
            ->setDescription('this is a red coffee cup!')
            ->setproductId(11)
            ->setPrice(8.99);
        $itemUom = new Entity\ItemUom;
        $item1 = new Entity\Item;
        $item1->setItemId(88)
            ->setItemNumber('redcup123')
            ->addUom($itemUom);
        $red->setItem($item1);
        $choice1->setProduct($red)->setOverrideName('red');

        $choice2 = new Entity\Choice;
        $choice2->setChoiceId(123);
        $blue = new Entity\Product('product');
        $blue->setName('blue coffee cup')
            ->setDescription('this is the description for the blue one')
            ->setProductId(22)
            ->setPrice(8.99);
        $item2 = new Entity\Item;
        $item2->setItemId(99)
            ->setItemNumber('bluecup123');
        $blue->setItem($item2);
        $choice2->setProduct($blue)->setOverrideName('blue');

        $option->setChoices(array($choice1, $choice2));

        $product->addOption($option);

        $this->rows = array( 
            'option-'.$option->getOptionId() => $option, 
            'product-'.$product->getProductId() => $product,
            'product-'.$red->getProductId() => $red,
            'product-'.$blue->getProductId() => $blue,
        );   

    }

    public function readSessionEntities()
    {
        return $this->rows;
    }
}
