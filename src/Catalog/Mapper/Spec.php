<?php

namespace Catalog\Mapper;

class Spec extends AbstractMapper
{
    protected $tableName = 'catalog_product_spec';
    protected $entityPrototype = '\Catalog\Entity\Spec';
    protected $hydrator = 'Catalog\Hydrator\Spec';

    public function find($specId)
    {
        $table = $this->getTableName();
        $where = array('spec_id' => $specId);
        $select = $this->select()
            ->from($table)
            ->where($where);
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $table = $this->getTableName();
        $where = array('product_id' => $productId);
        $select = $this->select()
            ->from($table)
            ->where($where);
        return $this->selectMany($select);
    }

    public function persist($spec)
    {
        if(null === $spec->getSpecId()){
            $id = $this->insert($spec);
            return $spec->setSpecId($id);
        }
        if($this->find($spec->getSpecId())) {
            $where = array('spec_id' => $specId);
            return $this->update($spec, $where);
        }else{
            $id = $this->insert($spec);
            return $spec->setSpecId($id);
        }
    }
}
