<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\Form\Form as ZendForm;

class UomToCart extends AbstractHelper
{

    protected $partials = array(
        'single' => '/speck-catalog/product/product-uom/single',
        'few' => '/speck-catalog/product/product-uom/few',
        'many' => '/speck-catalog/product/product-uom/many',
    );

    /**
     * how many uoms before we change the display style from few to many
     */
    protected $fewVsMany = 3;

    /**
     * whether or not to use "of 1" when the quantity of a uom is 1
     * example: 'Each of 1' or just 'Each'
     */
    protected $of1 = false;

    public function __invoke(array $uoms, $uomString = null, $quantity = 1)
    {
        if (count($uoms) === 1) {
            return $this->renderOne($uoms[0], $quantity);
        } elseif (count($uoms) <= $this->fewVsMany) {
            return $this->renderFew($uoms, $uomString, $quantity);
        } else {
            return $this->renderMany($uoms, $uomString, $quantity);
        }
    }

    /**
     * this will render the javascript/etc needed
     * to bring back the uoms, once a builder is configured.
     */
    public function builder(\SpeckCatalog\Model\Product $product)
    {
        $builder = json_encode($product->getBuilder());
    }


    public function renderOne($uom, $quantity = 1)
    {
        $form = $this->newForm($uom, true, $quantity);
        $uomTranslated = $this->translateUom($uom);
        $view = new ViewModel(array('form' => $form, 'uom' => $uom, 'uomTranslated' => $uomTranslated));
        $view->setTerminal(true)->setTemplate($this->partials['single']);
        $return = $this->getView()->render($view);

        return $return;
    }

    public function renderFew($uoms, $uomString = null, $quantity = 1)
    {
        $options = array();
        foreach ($uoms as $uom) {
            $options[$this->uomtokey($uom)] = $this->translateUom($uom);
        }

        $form = $this->newForm(null, false, $quantity);
        $form->add(array(
            'name' => 'uom',
            'type' => 'Zend\Form\Element\Radio',
            'attributes' => array(
                'type' => 'select',
                'options' => $options,
            ),
            'options' => array(
                'label' => 'Unit Of Measure',
            ),
        ));

        $selectedUomString = $this->selectUomString($uoms, $uomString);
        $form->get('uom')->setValue($selectedUomString);

        $view = new ViewModel(array('form' => $form, 'uoms' => $uoms));
        $view->setTerminal(true)->setTemplate($this->partials['few']);
        return $this->getView()->render($view);
    }

    public function translateUom($uom)
    {
        if ($uom->getQuantity() === 1 && $this->of1 === false) {
            return $uom->getUom()->getName();
        } else {
            return $uom->getUom()->getName() . ' of ' . $uom->getQuantity();
        }
    }

    public function uomToKey($uom)
    {
        return $uom->getProductId() . ':' . $uom->getUomCode() . ':' . $uom->getQuantity();
    }

    public function renderMany($uoms, $uomString = null, $quantity = 1)
    {
        foreach ($uoms as $uom) {
            $options[$this->uomToKey($uom)] = $this->translateUom($uom) . ' : $' . number_format($uom->getPrice(), 2);
        }

        $form = $this->newForm(null, false, $quantity);
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
        $selectedUomString = $this->selectUomString($uoms, $uomString);
        $form->get('uom')->setValue($selectedUomString);

        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true)->setTemplate($this->partials['many']);
        return $this->getView()->render($view);
    }

    public function selectUomString($uoms, $uomString='')
    {
        foreach ($uoms as $uom) {
            if ($uomString === $this->uomToKey($uom)) {
                return $uomString;
            }
        }
        return $this->uomToKey($uoms[0]);
    }

    public function newForm($uom=null, $uomTextField=false, $quantity = 1)
    {
        $form = new ZendForm();

        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'class' => 'btn add-to-cart',
            ),
            'options' => array(
                'label' => 'Add To Cart',
            ),
        ));
        $form->add(array(
            'name' => 'quantity',
            'attributes' => array(
                'type' => 'text',
                'value' => $quantity,
                'id' => 'quantity-to-cart',
            ),
            'options' => array(
                'label' => 'Quantity',
            ),
            'value' => $quantity,
        ));
        $form->get('quantity')->setValue($quantity);

        if($uomTextField) {
            $form->add(array(
                'name' => 'uom',
                'attributes' => array(
                    'type' => 'hidden',
                ),
            ));
            $form->get('uom')->setValue($this->uomToKey($uom));
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
