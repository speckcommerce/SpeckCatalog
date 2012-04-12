<?php

namespace Catalog\Service;

class Installer
{
    protected $mapper;

    public function install()
    {
        $this->getMapper()->createCatalog();
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

    public function getMapper()
    {
        return $this->mapper;
    }

    public function setMapper($mapper)
    {
        if($mapper instanceof \Catalog\Model\Mapper\ModelMapperAbstract){
            $this->mapper = $mapper;
        }else{
            var_dump($mapper);
            die('not instance of ModelMapperAbstract');
        }
        return $this;
    }    
}   
