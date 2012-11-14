<?php

namespace Catalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class UomToCart extends AbstractHelper
{
    /**
     * how many uoms before we change the display style from few to many
     * you may use a value above 3, but you may end up with undesired results.
     */
    protected $fewVsMany = 3;

    /**
     * whether or not to use "of 1" when the quantity of a uom is 1
     * example: 'Each of 1' or just 'Each'
     */
    protected $of1 = false;

    public function __invoke(array $uoms)
    {
        if (count($uoms) === 1) {
            return $this->renderOne($uoms[0]);
        } elseif (count($uoms) <= $this->fewVsMany) {
            return $this->renderFew($uoms);
        } else {
            return $this->renderMany($uoms);
        }
    }

    public function renderOne($uom)
    {
        $partial = '/catalog/product/product-uom/single';
        $form = $this->newForm($uom, true);
        $view = new ViewModel(array('form' => $form, 'uom' => $uom, 'uomTranslated' => $this->translateUom($uom)));
        $view->setTerminal(true)->setTemplate($partial);
        $return = $this->getView()->render($view);

        return $return;
    }

    public function renderFew($uoms)
    {
        $partial = '/catalog/product/product-uom/few';

        $return = '';
        foreach ($uoms as $uom) {
            $form = $this->newForm($uom, true);
            $view = new ViewModel(array('form' => $form, 'uom' => $uom, 'uomTranslated' => $this->translateUom($uom)));
            $view->setTerminal(true)->setTemplate($partial);
            $return .= $this->getView()->render($view);
        }

        return $return;
    }

    public function translateUom($uom)
    {
        if ($uom->getQuantity() === 1 && $this->of1 === false) {
            return $uom->getUom()->getName();
        } else {
            return $uom->getUom()->getName() . ' of ' . $uom->getQuantity();
        }
    }


    public function renderMany($uoms)
    {
        $partial = '/catalog/product/product-uom/many';

        foreach ($uoms as $uom) {
            $key = $uom->getUomCode() . '[' . $uom->getQuantity() . ']';
            $options[$key] = $this->translateUom($uom) . ' : $' . number_format($uom->getPrice(), 2);
        }

        $form = $this->newForm();
        $form->add(array(
            'name' => 'uom',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'type' => 'select',
                'options' => $options,
            ),
            'options' => array(
                'label' => 'Unit Of Measure',
            ),
        ));

        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true)->setTemplate($partial);
        return $this->getView()->render($view);
    }



    public function newForm($uom=null, $uomTextField=false)
    {
        $form = new Form();

        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Add To Cart',
            ),
        ));
        $form->add(array(
            'name' => 'quantity',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Quantity',
            ),
            'value' => 1,
        ));

        if($uomTextField) {
            $value = $uom->getUomCode() . '[' . $uom->getQuantity() . ']';
            $form->add(array(
                'name' => 'uom',
                'attributes' => array(
                    'type' => 'hidden'
                ),
                'value' => $value,
            ));
        }

        return $form;
    }

    /**
     * @return fewVsMany
     */
    public function getFewVsMany()
    {
        return $this->fewVsMany;
    }

    /**
     * @param $fewVsMany
     * @return self
     */
    public function setFewVsMany($fewVsMany)
    {
        $this->fewVsMany = $fewVsMany;
        return $this;
    }
}
