<?php

namespace SpeckCatalog\Model\Helper;

use SpeckCatalog\Service\ServiceAbstract;

class OptionHelperListener extends ServiceAbstract
{
    protected $helpers;

    public function getChoices($e)
    {
        $optionId = $e->getTarget()->getOptionId();
        var_dump($optionId);die();
        $helpers = $this->getModelMapper()->getHelpers('productuom', $optionId);
        $choices = $e->getParam('choices');
        var_dump($helpers); die();
        foreach($helpers as $helper){
            $choices = $helper->setChoices($choices);
        }
        $e->getTarget()->setChoices($choices);
    }

}
