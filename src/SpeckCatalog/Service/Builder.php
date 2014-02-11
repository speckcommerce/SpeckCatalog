<?php

namespace SpeckCatalog\Service;

class Builder extends AbstractService
{
    protected $entityMapper   = 'speckcatalog_builder_product_mapper';
    protected $productService = 'speckcatalog_product_service';
    protected $choiceService  = 'speckcatalog_choice_service';
    protected $optionService  = 'speckcatalog_option_service';

    public function getBuilders(array $data, $populate=false, $recursive=false)
    {
        $rows = $this->getEntityMapper()->getLinkers($data);
        if (!$rows) {
            return false;
        }

        $builders = array();
        foreach ($rows as $row) {
            $pid = $row['product_id'];
            if (!isset($builders[$pid])) {
                $builders[$pid] = $this->getModel($row);
            }
            $builders[$pid]->addSelected($row['option_id'], $row['choice_id']);
        }

        foreach ($builders as $builder)
        {
            $productId = $builder->getProductId();
            $product   = $this->getProductService()->find(array('product_id' => $productId), true, true);
            $builder->setProduct($product);
        }

        return $builders;
    }

    public function find(array $data, $populate=false, $recursive=false)
    {
        throw new \Exception('method not implemented for builders');
    }

    public function persistModel($model)
    {
        $data = array(
            'product_id' => $model->getProductId(),
            'selected'   => $model->getSelected(),
        );
        $this->persistData($data);
    }

    public function persistData($data)
    {
        foreach ($data['selected'] as $optionId => $choiceId) {
            $row = array(
                'product_id' => $data['product_id'],
                'option_id'  => $optionId,
                'choice_id'  => $choiceId
            );
            $this->getEntityMapper()->persist($row);
        }
    }

    public function persist($form)
    {
        $data = $form->getData();

        $this->persistData($data);

        $where = array(
            'product_id'        => $data['product_id'],
            'parent_product_id' => $data['parent_product_id']
        );

        $builders = $this->getBuilders($where);
        return array_shift($builders);
    }



    public function getBuildersByParentProductId($productId)
    {
        $where = array('parent_product_id' => $productId);
        return $this->getBuilders($where, true, true);
    }

    public function getModel($construct = null)
    {
        $model = parent::getModel($construct);
        if (is_array($construct) && isset($construct['parent_product_id'])) {
            $optionService = $this->getOptionService();
            $options = $optionService->getByProductId(
                $construct['parent_product_id'], array('choices'),
                true, array('builder' => 1)
            );
            $model->setOptions($options);
        }
        return $model;
    }

    public function validBuildersJson($builders)
    {
        $data = array();

        foreach($builders as $builder) {
            $pid = $builder->getProductId();
            $data[$pid] = implode(',', $builder->getSelected());
        }
        return json_encode($data);
    }

    public function getProduct($productId)
    {
        return $this->getProductService()->find(array('product_id' => $productId));
    }

    public function newBuilderForProduct($childProductId, $parentProductId)
    {
        $data = array(
            'parent_product_id' => $parentProductId,
            'product_id'        => $childProductId,
        );
        return $this->getModel($data);
    }

    public function getProductService()
    {
        if (is_string($this->productService)) {
            $this->productService = $this->getServiceLocator()->get($this->productService);
        }
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }

    public function getChoiceService()
    {
        if (is_string($this->choiceService)) {
            $this->choiceService = $this->getServiceLocator()->get($this->choiceService);
        }
        return $this->choiceService;
    }

    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }

    public function getOptionService()
    {
        if (is_string($this->optionService)) {
            $this->optionService = $this->getServiceLocator()->get($this->optionService);
        }
        return $this->optionService;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }
}
