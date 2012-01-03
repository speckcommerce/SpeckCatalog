<?php
namespace SpeckCatalogManager\Service;
class CatalogManagerService
{
    protected $session=null;

    public function getSession(\EdpUser\Model\User $user)
    {
        if($this->session){
            return $this->session;
        }

        $mapper = new \SpeckCatalogManager\Model\Mapper\SessionMapper($user->getUserId());
        $this->session = new \SpeckCatalogManager\Model\Session;
        $this->session->setEntities($mapper->readSessionEntities());

        return $this->session;
    } 
    public function getEntity($className, $entityId)
    {
        $entityName = '\SpeckCatalogManager\Entity\\'.ucfirst($className);
        return new $entityName('radio');
    }
}
