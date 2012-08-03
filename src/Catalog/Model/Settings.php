<?php

namespace Catalog\Model;

class Settings
{
    protected $settings = array();

    public function __construct($arr)
    {
        $this->setSettings($arr);
    }

    function setSettings($settings)
    {
        $this->settings = $settings;
    }

    function getSettings()
    {
        return $this->settings;
    }

    public function get($key)
    {
        return $this->settings[$key];
    }
}
