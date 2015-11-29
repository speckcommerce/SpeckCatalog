<?php

namespace SpeckCatalog\Event;

class FileUpload
{
    public function preFileUpload($e)
    {
        $formData = $e->getParam('params');
        $getter = 'get' . ucfirst($formData['file_type']) . 'Upload';

        $catalogOptions = $this->getServiceManager()->get('speckcatalog_module_options');

        if ($formData['file_type'] === 'productDocument') {
            $e->getParam('options')->setAllowedFileTypes(['pdf' => 'pdf']);
            $e->getParam('options')->setUseMin(false);
            $e->getParam('options')->setUseMax(false);
        }

        $appRoot = __DIR__ . '/../..';
        $path = $appRoot . $catalogOptions->$getter();
        $e->getParam('options')->setDestination($path);
    }

    public function postFileUpload($e)
    {
        $params = $e->getParams();
        switch ($params['params']['file_type']) {
            case 'productImage':
                $imageService = $this->getServiceManager()->get('speckcatalog_product_image_service');
                $image = $imageService->getEntity();
                $image->setProductId($params['params']['product_id'])
                    ->setFileName($params['fileName']);
                $imageService->persist($image);
                break;
            case 'productDocument':
                $documentService = $this->getServiceManager()->get('speckcatalog_document_service');
                $document = $documentService->getEntity();
                $document->setProductId($params['params']['product_id'])
                    ->setFileName($params['fileName']);
                $documentService->persist($document);
                break;
            case 'optionImage':
                $imageService = $this->getServiceManager()->get('speckcatalog_option_image_service');
                $image = $imageService->getEntity();
                $image->setOptionId($params['params']['option_id'])
                    ->setFileName($params['fileName']);
                $imageService->persist($image);
                break;
            default:
                throw new \Exception('no handler for file type - ' . $params['params']['file_type']);
        }
    }
}
