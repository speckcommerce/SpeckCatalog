<?php

namespace Catalog\Model;

interface ModelInterface
{
    public function getId();
    public function setId($id);
    public function __toString();
}
