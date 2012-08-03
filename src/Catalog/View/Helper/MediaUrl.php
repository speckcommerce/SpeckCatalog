<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;

class MediaUrl extends AbstractHelper
{
    protected $mediaType;

    protected $settings;

    protected $partialDir = "catalog/catalog-manager/partial/form/";

    public function __construct($settings, $mediaType)
    {
        $this->setSettings($settings);
        $this->setMediaType($mediaType);
    }

    public function category($media)
    {
        $getter = 'getCategory' . $this->getMediaType() . 'Path';
        return $this->settings->$getter($media) . '/' . $media->getFileName();
    }

    public function option($media)
    {
        $getter = 'getCategory' . $this->getMediaType() . 'Path';
        return $this->settings->$getter($media) . '/' . $media->getFileName();
    }

    public function product($media)
    {
        $getter = 'getCategory' . $this->getMediaType() . 'Path';
        return $this->settings->$getter($media) . '/' . $media->getFileName();
    }

    function getSettings()
    {
        return $this->settings;
    }

    function setSettings($settings)
    {
        $this->settings = $settings;
    }

    function getMediaType()
    {
        return $this->mediaType;
    }

    function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
    }
}
