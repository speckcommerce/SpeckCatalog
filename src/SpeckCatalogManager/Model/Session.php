<?php
namespace SpeckCatalogManager\Model;

class Session
{
    protected $user;
    protected $entities;
 
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getEntities()
    {
        return $this->entities;
    }

    public function setEntities($entities)
    {
        $this->entities = $entities;
        return $this;
    }
    public function getEntityById($entityId)
    {
        if(!isset($this->entities[$entityId])){
            return false;
        }
        return $this->entities[$entityId];
    }
    public function newEntity($entity)
    {
        $this->entities[] = $entity;
        return $this;
    }
}
