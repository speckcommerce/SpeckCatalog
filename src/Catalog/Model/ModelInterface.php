<?php
namespace Catalog\Model;
interface ModelInterface
{
    public function getRecordId();
    public function setRecordId($id);
    public function __toString();
}
