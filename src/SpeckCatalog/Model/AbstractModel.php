<?php

namespace SpeckCatalog\Model;

class AbstractModel
{
    public function __construct(AbstractModel $model = null)
    {
        if ($model) {
            foreach (get_object_vars($this) as $key => $val) {
                $getter = 'get' . ucfirst($key);
                $setter = 'set' . ucfirst($key);
                if (method_exists($this, $setter) && method_exists($model, $getter)) {
                    $this->$setter($model->$getter());
                }
            }
        }
        return $this;
    }

    public function has($prop)
    {
        $getter = 'get' . ucfirst($prop);
        if (method_exists($this, $getter)) {
            if ('s' === substr($prop, 0, -1) && is_array($this->$getter())) {
                return true;
            } elseif ($this->$getter()) {
                return true;
            }
        }
    }

    public function __toString()
    {
        return get_class($this);
    }
}
