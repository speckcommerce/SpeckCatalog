<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ConfigureBuy extends AbstractHelper
{
    public function __invoke($product, $formId)
    {
        if ($product->has('uoms') && count($product->getUoms()) > 1) {
            $this->uomSelection();
        }
        if ($product->getProductTypeId() == 1) {
            $this->uomSelection();
            $this->builders($product->getBuilders(), $formId);
        }
        return;
    }

    public function uomSelection()
    {
        $this->getView()->uomSelection = true;
    }

    public function builders($builders, $formId)
    {
        $data = array();
        foreach ($builders as $builder) {
            $data[$builder->getProductId()] = array_values($builder->getSelected());
        }
        $builderJson = json_encode($data);

        $script = <<<js
var builders = {$builderJson};
jQuery('document').ready(function(){
    uomBuilders(jQuery('form#{$formId}'), builders);
});
js;

        $this->getView()->headScript()
            ->appendFile('/js/configure-buy.js')
            ->appendScript($script);
    }
}
