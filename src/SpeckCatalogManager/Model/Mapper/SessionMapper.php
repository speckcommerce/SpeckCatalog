<?php
namespace SpeckCatalogManager\Model\Mapper;
class SessionMapper
{
    protected $userId;
    protected $entities;

    public function __construct($userId)
    {
        // test entities
        $product = new \SpeckCatalogManager\Entity\Product('product');
        $product->setName('hi, im the name of a product');
        $itemUom = new \SpeckCatalogManager\Entity\ItemUom;
        $uom = new \SpeckCatalogManager\Entity\Uom;
        $uom->setName('name of uom!');
        $itemUom->setUom($uom);
        $choice = new \SpeckCatalogManager\Entity\Choice;
        $choice->setName('hi, im the name of a choice');
        $choice->setProduct($product);
        //$choice->setProduct($product);
        //$company = new \SpeckCatalogManager\Entity\Company;
        //$company->setName('companyname!');
        $option = new \SpeckCatalogManager\Entity\Option('radio');
        $option->setName('im an option name')
            ->setChoices(array($choice))
            ->setParentProducts(array($product, $product, $product, $product));
        $item = new \SpeckCatalogManager\Entity\Item;
        $item->setName('im an item name')->addUom($itemUom);
        $product->setItem($item)->addOption($option);
        $product->setParentChoices(array($choice, $choice, $choice));

      //$product->addOption($option2);
      //$choice = new \SpeckCatalogManager\Entity\Choice;
      //$choice->setName('this is the override name of the choice');
      //$product->setParentChoices(array($choice,$choice));

        $this->rows = array($option, $product, $option);
    }

    public function readSessionEntities()
    {
        return $this->rows;
    }



}
