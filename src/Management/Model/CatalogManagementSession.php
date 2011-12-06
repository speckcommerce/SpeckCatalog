<?php
namespace Management\Model;

class CatalogManagementSession
{
    protected $user;
    protected $entities;
 
    /**
     * Get user.
     *
     * @return user
     */
    public function getUser()
    {
        return $this->user;
    }
 
    /**
     * Set user.
     *
     * @param $user the value to be set
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
 
    /**
     * Get entities.
     *
     * @return entities
     */
    public function getEntities()
    {
        return $this->entities;
    }
 
    /**
     * Set entities.
     *
     * @param $entities the value to be set
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
        return $this;
    }
}
