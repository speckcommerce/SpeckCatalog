<?php
namespace Management\Model\Mapper;
class CatalogManagementSessionMapper
{
    protected $userId;
    protected $entities;

    public function __construct($userId)
    {
        $this->userId = $userId;
        
        // test entities
        $shell = new \Management\Entity\Shell('product');
        $product = new \Management\Entity\Product;
        $option = new \Management\Entity\Option('radio');
       
        $manufacturer = new \Management\Entity\Company;
        $manufacturer->setCompanyId(69); 
        $product->setProductId(10)
                ->setManufacturer($manufacturer);
        $shell->setProduct($product);
        $choice = new \Management\Entity\Choice;
        $choice->setChoiceId(12);
        $option->setOptionId(7)
               ->addChoice($choice)
               ->setSelectedChoice($choice);
        $shell->addOption($option);
        $this->rows = $this->entitiesToRows(array($option, $shell, $product));
    }


    public function readSessionEntities()
    {
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
