<?php
namespace Management\Service;
class CatalogManagementService
{
    protected $session=null;

    public function getSession($user)
    {
        //if($user->getPermissions('speckcatalog_catalog_management') !=== true) return false;
        
        if($this->session){
            return $this->session;
        }

        $mapper = new \Management\Model\Mapper\CatalogManagementSessionMapper($user->getUserId());
        $this->session = new \Management\Model\CatalogManagementSession;
        $this->session->setEntities($mapper->readSessionEntities());

        return $this->session;
    }
}
