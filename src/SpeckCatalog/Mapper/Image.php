<?php

namespace SpeckCatalog\Mapper;

class Image extends AbstractMapper
{
    protected $tableName;
    protected $model;
    protected $parentType;

    protected $fields = [
        'product' => ['image_id', 'product_id', 'sort_weight', 'file_name', 'label'],
        'option'  => ['image_id', 'option_id', 'sort_weight', 'file_name', 'label'],
    ];

    protected $keyFields = [
        'product' => ['image_id'],
        'option'  => ['image_id'],
    ];

    protected $models = [
        'product' => 'SpeckCatalog\Model\ProductImage\Relational',
        'option'  => 'SpeckCatalog\Model\OptionImage\Relational',
    ];

    public function setParentType($parentType)
    {
        if (!in_array($parentType, ['product', 'option'])) {
            throw new \Exception('invalid type');
        }
        $this->parentType = $parentType;
        $this->tableName  = 'catalog_' . $parentType . '_image';
        $this->model      = $this->models[$parentType];

        return $this;
    }

    public function getImages($type, $id)
    {
        $this->setParentType($type);
        $where  = [$type . '_id' => $id];
        $select = $this->getSelect()
            ->where($where);
        return $this->selectManyModels($select);
    }

    public function getParentType()
    {
        return $this->parentType;
    }

    public function getTableFields()
    {
        $type = $this->getParentType();
        return $this->fields[$type];
    }

    public function getTableKeyFields()
    {
        $type = $this->getParentType();
        return $this->keyFields[$type];
    }
}
