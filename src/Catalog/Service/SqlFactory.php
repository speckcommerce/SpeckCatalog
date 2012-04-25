<?php
namespace Catalog\Service;
class SqlFactory
{
    protected $insert;
    protected $select;
    protected $update;
    protected $delete;
    protected $where;


    public function construct($type=null)
    {
        $method = 'get' . ucfirst($type);

        if(is_callable($this, $method)){
            return $this->$method();
        }
    } 

    public function getInsert()
    {
        return $this->insert;
    }
 
    public function setInsert($insert)
    {
        $this->insert = $insert;
        return $this;
    }
 
    public function getSelect()
    {
        return $this->select;
    }

    public function setSelect($select)
    {
        $this->select = $select;
        return $this;
    }
 
    public function getUpdate()
    {
        return $this->update;
    }
 
    public function setUpdate($update)
    {
        $this->update = $update;
        return $this;
    }
 
    public function getDelete()
    {
        return $this->delete;
    }
 
    public function setDelete($delete)
    {
        $this->delete = $delete;
        return $this;
    }
}
    
