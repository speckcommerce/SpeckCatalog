<?php
namespace SpeckCatalogManager\Service;
class CatalogManagerService
{
    protected $session=null;

    public function getSession($user)
    {
        //if($user->getPermissions('speckcatalog_catalog_management') !=== true) return false;
        
        if($this->session){
            return $this->session;
        }

        $mapper = new \SpeckCatalogManager\Model\Mapper\SessionMapper($user->getUserId());
        $this->session = new \SpeckCatalogManager\Model\Session;
        $this->session->setEntities($mapper->readSessionEntities());

        return $this->session;
    }
}
