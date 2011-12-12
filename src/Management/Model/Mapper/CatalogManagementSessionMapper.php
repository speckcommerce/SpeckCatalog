<?php
namespace Management\Model\Mapper;
class CatalogManagementSessionMapper
{
    protected $userId;
    protected $entities;

    public function __construct($userId)
    {
        // test entities
        $product = new \Management\Entity\Product;
        $product->setName('<font color="red">hi, im a product from a session!</font>');
        $shell = new \Management\Entity\Shell('product');
        $shell->setProduct($product)->setName('<font color="red">hi, im a shell from a session!</font>');
        $option = new \Management\Entity\Option('radio');
        $option->setName('<font color="red">hello! im an option from a session!</font>');
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
