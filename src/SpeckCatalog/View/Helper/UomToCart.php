<?php

namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Form\Form;
use SpeckCatalog\Model\ProductUom\Relational as ProductUom;
use SpeckCatalog\Model\Product\Relational as ProductModel;

class UomToCart extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $services = array(
        'product_uom' => 'speckcatalog_product_uom_service',
        'product'     => 'speckcatalog_productservice',
        'builder'     => 'speckcatalog_builder_product_service',
    );

    protected $templates = array(
        'single' => '/speck-catalog/product/product-uom/single',
        'few'    => '/speck-catalog/product/product-uom/few',
        'many'   => '/speck-catalog/product/product-uom/many',
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

    //product can be product model or productId
    public function __invoke($product, $builderProductId = null, $uomString = null, $quantity = 1)
    {
        if (!$product) {
            return;
        }
        if (is_numeric($product)) {
            $product = $this->getService('product')->find(array('product_id' => $product), array('builders', 'uoms'));
        }
        $uoms = $this->uomsForProduct($product);
        if ($builderProductId) {
            $productUoms = $this->getService('product_uom')->getByProductId($builderProductId);
            $uoms = $this->mergeEnabledUoms($productUoms, $uoms);
        }
        return $this->renderUoms($uoms, $uomString, $quantity);
    }

    public function uomsForProduct(ProductModel $product)
    {
        if ($product->getProductTypeId() == 1) {
            return $this->buildersToUomsArray($product->getBuilders());
        }
        return $this->mergeEnabledUoms($product->getUoms());
    }

    //merge some enabled uoms into an array of disabled uoms
    public function mergeEnabledUoms(array $enabled, array $uoms = array())
    {
        foreach ($enabled as $uom) {
            $uomArray = $this->uomToArray($uom, true);
            $uoms[$uomArray['uom_string']] = $uomArray;
        }
        return $uoms;
    }

    //returns array of "disabled" uoms
    public function buildersToUomsArray(array $builders)
    {
        $uoms = array();
        foreach ($builders as $builder) {
            foreach ($builder->getProduct()->getUoms() as $uom) {
                $uomArray = $this->uomToArray($uom);
                $uoms[$uomArray['uom_string']] = $uomArray;
            }
        }
        return $uoms;
    }

    public function uomToArray(ProductUom $uom, $enabled = false)
    {
        $this->getService('product_uom')->populate($uom);
        //data needed to represent a uom to be displayed
        $data = array(
            'enabled'    => false,
            'key'        => $uom->getUomCode().$uom->getQuantity(),
            'price'      => 'N/A',
            'name'       => $uom->getUom()->getName(),
            'code'       => $uom->getUomCode(),
            'quantity'   => $uom->getQuantity(),
            'uom_string' => $uom->getUomCode().$uom->getQuantity(),
        );
        if ($enabled) {
            $data['enabled'] = true;
            $data['key'] = $uom->getProductId()
                . ':' . $uom->getUomCode()
                . ':' . $uom->getQuantity();
            $data['price'] = $uom->getPrice();
        }
        return $data;
    }

    public function renderUoms(array $uoms, $uomString = null, $quantity = 1)
    {
        if (count($uoms) === 1) {
            return $this->renderOne(array_pop($uoms), $quantity);
        } elseif (count($uoms) <= $this->fewVsMany) {
            return $this->renderFew($uoms, $uomString, $quantity);
        }
        return $this->renderMany($uoms, $uomString, $quantity);
    }

    public function renderOne($uom, $quantity = 1)
    {
        $form = $this->newForm($uom, true, $quantity);
        $uom['display_name'] = $this->getDisplayName($uom, true);

        $view = new ViewModel(array('form' => $form, 'uom' => $uom));
        $view->setTerminal(true)->setTemplate($this->templates['single']);

        return $this->getView()->render($view);
    }

    public function renderFew(array $uoms, $uomString = null, $quantity = 1)
    {
        $forms = array();
        foreach ($uoms as $i => $uom) {
            $uoms[$i]['display_name'] = $this->getDisplayName($uom, true);
            $child = $this->newForm($uom);
            $child->get('submit')->setName('uom')->setValue($uom['key']);
            $forms[$uom['uom_string']] = $child;
        }

        $view = new ViewModel(array('forms' => $forms, 'uoms' => $uoms));
        $view->setTerminal(true)->setTemplate($this->templates['few']);

        return $this->getView()->render($view);
    }

    public function getDisplayName($uom, $appendPrice = false)
    {
        if ($uom['quantity'] === 1 && $this->of1 === false) {
            $name = $uom['name'];
        } else {
            $name = $uom['name'] . ' of ' . $uom['quantity'];
        }
        if ($appendPrice) {
            $name .= ' - ' . $this->displayPrice($uom['price']);
        }
        return $name;
    }

    public function displayPrice($price)
    {
        if (is_numeric($price)) {
            return '$' . number_format($price, 2);
        }
        return $price;
    }

    public function renderMany($uoms, $uomString = null, $quantity = 1)
    {
        foreach ($uoms as $uom) {
            $key= $uom['key'];
            $options[$key] = array(
                'value' => $key,
                'label' => $this->getDisplayName($uom, true),
            );
            if ($uom['enabled'] == false) {
                $options[$key]['attributes'] = array('disabled' => 'disabled');
            }
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
                'empty_option' => '',
                'label' => 'Unit Of Measure',
            ),
        ));
        $selectedUomString = $this->selectUomString($uoms, $uomString);
        $form->get('uom')->setValue($selectedUomString);

        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true)->setTemplate($this->templates['many']);
        return $this->getView()->render($view);
    }

    public function selectUomString(array $uoms = array(), $uomString = '')
    {
        foreach ($uoms as $uom) {
            if ($uomString === $uom['uom_string']) {
                return $uomString;
            }
        }
    }

    public function newForm($uom = null, $uomTextField = false, $quantity = 1)
    {
        $form = new Form($uom['uom_string']);

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

        if ($uomTextField) {
            $form->add(array(
                'name' => 'uom',
                'attributes' => array(
                    'type' => 'hidden',
                ),
            ));
            $form->get('uom')->setValue($uom['key']);
        }

        return $form;
    }

    public function getFewVsMany()
    {
        return $this->fewVsMany;
    }

    public function setFewVsMany($fewVsMany)
    {
        $this->fewVsMany = $fewVsMany;
        return $this;
    }

    public function getService($name)
    {
        if (!array_key_exists($name, $this->services)) {
            throw new \Exception('invalid service name');
        }
        if (is_string($this->services[$name])) {
            $this->services[$name] = $this->getServiceLocator()->getServiceLocator()->get($this->services[$name]);
        }
        return $this->services[$name];
    }
}
