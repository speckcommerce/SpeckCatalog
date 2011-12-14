<?php
namespace SpeckCatalogManager\Model\Mapper;
class SessionMapper
{
    protected $userId;
    protected $entities;

    public function __construct($userId)
    {
        // test entities
        $productUom = new \SpeckCatalogManager\Entity\ProductUom;

        $company = new \SpeckCatalogManager\Entity\Company;
        $company->setName('companyname!');
        $option = new \SpeckCatalogManager\Entity\Option('radio');
        $option->setName('<font color="red">hello! im an option from a session!</font>');
        $product = new \SpeckCatalogManager\Entity\Product('product');
        $product->setName('<font color="red">hi, im a product from a session!</font>');
        $item = new \SpeckCatalogManager\Entity\Item;
        $item->setName('<font color="red">hi, im an item from a session!</font>')
            ->setUoms(array($productUom))
            ->setManufacturer($company);
        $product->setItem($item)->addOption($option);
        $choice = new \SpeckCatalogManager\Entity\Choice;
        $choice->setName('this is the override name of the choice');
        $product->setParentChoices(array($choice,$choice));

        //$this->rows = $this->entitiesToRows(array($option, $product, $option));
        $this->rows = array($option, $product, $option);
    }

    public function readSessionEntities()
    {
        // keep them populated for now
        return $this->rows;
        return $this->rowsToEntities($this->rows);
    }

    public function rowsToEntities($rows)
    {
        $entities = array();
        foreach ($rows as $row){
            $entities[] = unserialize($row['entity']);
        }
        return $entities;
    }

    public function entitiesToRows($entities)
    {
        $rows = array();
        foreach ($entities as $entity){
            $class = get_class($entity);
            $classArr = explode('\\', $class);
            $className = array_pop($classArr);

            $entity->deflate();

            $rows[] = Array(
                'user_id' => $this->userId,
                'entity' => serialize($entity),
                'classname' => $className
            );
        }
        return $rows;
    }

}
