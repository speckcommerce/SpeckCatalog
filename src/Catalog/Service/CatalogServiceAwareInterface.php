<?php

namespace Catalog\Service;

interface CatalogServiceAwareInterFace
{
    public function setCatalogService($catalogService);
    public function getCatalogService();
}
