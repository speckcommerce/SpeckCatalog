<?php
namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\AbstractHelper;

class MediaUrl extends AbstractHelper
{
    protected $mediaType;

    protected $settings;

    public function __construct($settings, $mediaType)
    {
        $this->setSettings($settings);
        $this->setMediaType($mediaType);
    }

    public function getFileName($media)
    {
        if (is_string($media)) {
            return $media;
        }
        return $media->getFileName();
    }

    public function category($media)
    {
        $fileName = $this->getFileName($media);

        $getter = 'getCategory' . $this->getMediaType() . 'Path';
        return $this->settings->$getter($media) . '/' . $fileName;
    }

    public function option($media)
    {
        $fileName = $this->getFileName($media);

        $getter = 'getCategory' . $this->getMediaType() . 'Path';
        return $this->settings->$getter($media) . '/' . $fileName;
    }

    public function product($media)
    {
        $fileName = $this->getFileName($media);

        $getter = 'getProduct' . $this->getMediaType() . 'Path';
        return $this->settings->$getter($media) . '/' . $fileName;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }

    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
    }
}
