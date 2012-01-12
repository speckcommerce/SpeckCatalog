<?php
namespace SpeckCatalog\Model;

abstract class RevisionAbstract
{
    
    protected $userId;
    protected $datetime;
    protected $parentId;
    protected $id;

    /**
     * Get userId.
     *
     * @return userId
     */
    public function getUserId()
    {
        return $this->userId;
    }
 
    /**
     * Set userId.
     *
     * @param $userId the value to be set
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
 
    /**
     * Get parentId.
     *
     * @return parentId
     */
    public function getParentId()
    {
        return $this->parentId;
    }
 
    /**
     * Set parentId.
     *
     * @param $parentId the value to be set
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }
 
    /**
     * Get id.
     *
     * @return id
     */
    public function getId()
    {
        return $this->id;
    }
 
    /**
     * Set id.
     *
     * @param $id the value to be set
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
 
    /**
     * Get datetime.
     *
     * @return datetime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
 
    /**
     * Set datetime.
     *
     * @param $datetime the value to be set
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }
}
