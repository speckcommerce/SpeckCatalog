<?php

namespace SpeckCatalog\Service;

class Builder extends AbstractService
{
    protected $entityMapper = 'speckcatalog_builder_product_mapper';
    protected $productService;
    protected $choiceService;
    protected $optionService;

    public function getBuilders(array $data, $populate=false, $recursive = false)
    {
        $rows = $this->getEntityMapper()->getLinkers($data);
        if (!$rows) {
            return false;
        }

        $builders = array();
        $choiceService = $this->getChoiceService();
        foreach ($rows as $row) {
            $pid = $row['product_id'];
            if (!isset($builders[$pid])) {
                $builders[$pid] = $this->newBuilder($row);
            }
            $builders[$pid]->addSelected($row['option_id'], $row['choice_id']);
            $choice = $choiceService->find(array('choice_id' => $row['choice_id']));
            $builders[$pid]->addChoice($choice);
        }
        return $builders;
    }

    public function newBuilder($row)
    {
        $productService = $this->getProductService();
        $parent  = $productService->find(array('product_id' => $row['parent_product_id']));
        $product = $productService->find(array('product_id' => $row['product_id']));

        $model = $this->getModel($row);
        $model->setProduct($product);
        $model->setParent($parent);

        return $model;
    }

    public function find(array $data, $a=false, $b=false)
    {
        throw new \Exception('method not implemented for builders');
    }

    public function persist($form)
    {
        $data = $form->getData();

        foreach ($data['selected'] as $optionId => $choiceId) {
            $row = array(
                'product_id' => $data['product_id'],
                'option_id'  => $optionId,
                'choice_id'  => $choiceId
            );
            $this->getEntityMapper()->persist($row);
        }

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

    public function getBuildersByProductId($productId)
    {
        $mapper   = $this->getEntityMapper();
        $builders = $mapper->getBuildersByProductId($productId);
        $options = $mapper->getBuilderOptionsByProductId($productId);

        $return = array();
        foreach ($builders as $pid => $opts) {
            $return[$pid]['product_id'] = $pid;
            $return[$pid]['parent_product_id'] = $productId;
            $return[$pid]['product'] = $this->getProduct($pid);
            $return[$pid]['options'] = $options;
            foreach ($opts as $optionId => $choiceId) {
                $return[$pid]['options'][$optionId]['selected'] = $choiceId;
            }
        }

        return $return;
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

    public function newBuilderForProduct($builderProductId, $parentProductId)
    {
        $mapper  = $this->getEntityMapper();
        $options = $mapper->getBuilderOptionsByProductId($parentProductId, $builderProductId);
        $builder = array(
            'product_id'        => $builderProductId,
            'parent_product_id' => $parentProductId,
            'product'           => $this->getProduct($builderProductId),
            'options'           => $options,
        );

        return $builder;
    }

    public function getProductService()
    {
        if (null === $this->productService) {
            $this->productService = $this->getServiceLocator()->get('speckcatalog_product_service');
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
        if (null === $this->choiceService) {
            $this->choiceService = $this->getServiceLocator()->get('speckcatalog_choice_service');
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
        if (null === $this->optionService) {
            $this->optionService = $this->getServiceLocator()->get('speckcatalog_option_service');
        }
        return $this->optionService;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }
}
