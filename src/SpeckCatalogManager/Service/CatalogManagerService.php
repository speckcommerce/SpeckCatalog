<?php
namespace SpeckCatalogManager\Service;

use EdpUser\Model\User;

class CatalogManagerService
{
    protected $session=null;

    public function getSession(User $user=null)
    {
        if($this->session){
            return $this->session;
        }

        $mapper = new \SpeckCatalogManager\Model\Mapper\SessionMapper($user->getUserId());
        $this->session = $mapper->readSessionEntities();
        return $this->session;
    }
}
