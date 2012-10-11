<?php

namespace Catalog\Mapper;

class Spec extends AbstractMapper
{
    protected $tableName = 'catalog_product_spec';
    protected $relationalModel = '\Catalog\Model\Spec\Relational';
    protected $dbModel = '\Catalog\Model\Spec';

    public function find(array $data)
    {
        $table = $this->getTableName();
        $where = array('spec_id' => $data['spec_id']);
        $select = $this->getSelect()
            ->from($table)
            ->where($where);
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $table = $this->getTableName();
        $where = array('product_id' => $productId);
        $select = $this->getSelect()
            ->from($table)
            ->where($where);
        return $this->selectMany($select);
    }

    public function persist($spec)
    {
        $spec = $this->getDbModel($spec);
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
