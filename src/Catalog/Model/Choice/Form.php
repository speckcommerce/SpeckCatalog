<?php

namespace Catalog\Model\Choice;

use Catalog\Model\Choice as Base;

class Form extends Base
{
    protected $originalChoiceId;
    protected $originalOptionId;

    /**
     * @return originalChoiceId
     */
    public function getOriginalChoiceId()
    {
        return $this->originalChoiceId;
    }

    /**
     * @param $originalChoiceId
     * @return self
     */
    public function setOriginalChoiceId($originalChoiceId)
    {
        $this->originalChoiceId = $originalChoiceId;
        return $this;
    }

    /**
     * @return originalOptionId
     */
    public function getOriginalOptionId()
    {
        return $this->originalOptionId;
    }

    /**
     * @param $originalOptionId
     * @return self
     */
    public function setOriginalOptionId($originalOptionId)
    {
        $this->originalOptionId = $originalOptionId;
        return $this;
    }
}
