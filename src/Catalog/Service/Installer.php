<?php

namespace Catalog\Service;

class Installer
{
    private $catalogService;

    public function install()
    {
        $this->getCatalogService()->createCatalog();
        $this->copyDirectory('module/SpeckCatalog/public', 'public');
    }

    public function copyDirectory( $source, $destination ) {
        if ( is_dir( $source ) ) {
            @mkdir( $destination );
            $directory = dir( $source );
            while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
                if ( $readdirectory == '.' || $readdirectory == '..' ) {
                    continue;
                }
                $PathDir = $source . '/' . $readdirectory; 
                if ( is_dir( $PathDir ) ) {
                    $this->copyDirectory( $PathDir, $destination . '/' . $readdirectory );
                    continue;
                }
                copy( $PathDir, $destination . '/' . $readdirectory );
            }
     
            $directory->close();
        }else {
            copy( $source, $destination );
        }
    }

    public function getCatalogService()
    {
        return $this->catalogService;
    }
 
    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }
}   
