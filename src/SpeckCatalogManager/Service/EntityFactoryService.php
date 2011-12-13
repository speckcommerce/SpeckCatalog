<?php
namespace Management\Service;
use Management\Entity;
class EntityFactoryService
{
    public function shellFactory($type=null, $product=null, $options=null)
    {
        $shell = new Entity\Shell($type);
        if($product) $shell->setProduct($product);
        if($options) $shell->setOptions($options);
        return $shell;
    }

    public function productFactory($manufacturer=null, $productUoms=null)
    {
        $product = new Entity\Product;
        if($manufacturer) $product->setManufacturer($manufacturer);
        if($productUoms) $product->setUoms($productUoms);
        return $product;
    }

    public function productUomFactory($uom=null)
    {
        $productUom = new Entity\ProductUom;
        if($uom) $productUom->setUom($uom);
        return $productUom;
    }

    public function optionFactory($listType=null, $choices=null)
    {
        $option = new Entity\Option($listType);
        if($choices) $option->setChoices($choices);
        return $option;
    }

    public function choiceFactory($shell=null)
    {
        $choice = new Entity\Choice;
        if($shell) $choice->setShell($shell);
        return $choice;
    }
    
    public function availabilityFactory($company=null)
    {
        $availability = new Entity\Availability;
        if($company) $availability->setCompany($company);
        return $availability;
    }
}
