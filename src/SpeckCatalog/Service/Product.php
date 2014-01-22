<?php

namespace SpeckCatalog\Service;

class Product extends AbstractService
{
    protected $entityMapper = 'speckcatalog_product_mapper';
    protected $optionService;
    protected $productUomService;
    protected $imageService;
    protected $documentService;
    protected $specService;
    protected $companyService;
    protected $builderService;
    protected $categoryService;
    protected $choiceService;

    public function getAllProductsInCategories()
    {
        return $this->getEntityMapper()->getAllProductsInCategories();
    }

    public function update($data, array $where = null)
    {
        if (null === $where && is_array($data)) {
            $where['product_id'] = $data['product_id'];
        }
        if (null === $where && $data instanceOf \SpeckCatalog\Model\Product) {
            $where['product_id'] = $data->getProductId();
        }

        $vars = array(
            'data'  => $data,
            'where' => $where,
        );
        $this->getEventManager()->trigger('update.pre', $this, $vars);

        $result = parent::update($data, $where);
        $vars['result'] = $result;

        $this->getEventManager()->trigger('update.post', $this, $vars);

        return $result;
    }

    public function getCrumbs($product)
    {
        $crumbs = array($product);
        $categoryService = $this->getCategoryService();
        $parent = $categoryService->getByProductId($product->getProductId());
        if ($parent) {
            return $categoryService->getCrumbs($parent, $crumbs);
        }

        return $crumbs;
    }

    public function getParentCategory($productId)
    {
        return $this->getEntityMapper()->getParentCategory($productId);
    }

    public function getFullProduct($productId)
    {
        $product = $this->find(array('product_id' => $productId), true, true);
        if (!$product) {
            return false;
        }
        $this->populate($product, true);
        return $product;
    }

    public function populate($product, $recursive=false, $children=true)
    {
        $productId = $product->getProductId();

        $allChildren = ($children === true) ? true : false;
        $children    = (is_array($children)) ? $children : array();

        if ($allChildren || in_array('options', $children)) {
            $options = $this->getOptionService()->getByProductId($productId, true, $recursive);
            $product->setOptions($options);
        }

        if ($allChildren || in_array('images', $children)) {
            $images = $this->getImageService()->getImages('product', $productId);
            $product->setImages($images);
        }

        if ($allChildren || in_array('documents', $children)) {
            $documents = $this->getDocumentService()->getDocuments($productId);
            $product->setDocuments($documents);
        }

        if ($allChildren || in_array('uoms', $children)) {
            $uoms = $this->getProductUomService()->getByProductId($productId, true, $recursive);
            $product->setUoms($uoms);
        }

        if ($allChildren || in_array('specs', $children)) {
            $specs = $this->getSpecService()->getByProductId($productId);
            $product->setSpecs($specs);
        }

        if ($allChildren || in_array('manufacturer', $children)) {
            $manufacturer = $this->getCompanyService()->findById($product->getManufacturerId());
            $product->setManufacturer($manufacturer);
        }

        if ($product->getProductTypeId() == 1 && ($allChildren || in_array('builders', $children))) {
            $builders = $this->getBuilderService()->getBuildersByParentProductId($productId);
            $product->setBuilders($builders);
        }

        if ($allChildren || (in_array('options') && $children == true)) {
            $this->singleOptionBuilderSingleUom($product);
        }
    }

    //check if the product is has a single builder option,
    //and if all builder products share a common uom
    //set "add price" on choices, and return true
    public function singleOptionBuilderSingleUom($product)
    {
        if (!$product->has('options')) {
            return false;
        }
        $builderOptionCount = 0;
        $choices = array();
        foreach ($product->getOptions() as $option) {
            if ($option->getBuilder() == true) {
                $builderOptionCount++;
                //add the choices to a flat array
                foreach($option->getChoices() as $choice) {
                    $choices[$choice->getChoiceId()] = $choice;
                }
            }
            if ($builderOptionCount > 1) {
                return false;
            }
        }
        $allUoms = array();
        foreach ($product->getBuilders() as $builder) {
            $uoms = $builder->getProduct()->getUoms();
            if (count($uoms) > 1) {
                return false;
            }
            foreach ($uoms as $uom) {
                $str = $uom->getUomCode() . $uom->getQuantity();
                $allUoms[$str] = $str;
            }
        }
        if (count($allUoms) > 1) {
            return false;
        }

        //test is true, set the add price on the choices
        foreach ($product->getBuilders() as $builder) {
            foreach($builder->getSelected() as $optionId => $choiceId) {
                    $addPrice = $builder->getProduct()->getPrice() - $product->getPrice();
                $choices[$choiceId]->setAddPrice($addPrice);
            }
        }
        return true;
    }

    public function getProductsById(array $productIds = array())
    {
        return $this->getEntityMapper()->getProductsById($productIds);
    }

    public function addOption($productOrId, $optionOrId)
    {
        $productId = ( is_int($productOrId) ? $productOrId : $productOrId->getProductId() );
        $optionId  = ( is_int($optionOrId)  ? $optionOrId  : $optionOrId->getOptionId() );

        $this->getEntityMapper()->addOption($productId, $optionId);

        return $this->getOptionService()->find(array('option_id' => $optionId));
    }

    /**
     * store new sort order for product options
     * $order is array of position => optionId
     */
    public function sortOptions($productId, array $order)
    {
        return $this->getEntityMapper()->sortOptions($productId, $order);
    }

    public function removeOption(array $product, array $option)
    {
        $productId = $product['product_id'];
        $optionId  = $option['option_id'];

        return $this->removeOptionById($productId, $optionId);
    }

    public function removeOptionById($productId, $optionId)
    {
        return $this->getEntityMapper()->removeOption($productId, $optionId);
    }

    public function removeBuilder(array $product, array $builder)
    {
        $productId        = $product['product_id'];
        $builderProductId = $builder['product_id'];

        return $this->removeBuilderById($productId, $builderProductId);
    }

    public function removeBuilderById($productId, $builderProductId)
    {
        return $this->getEntityMapper()->removeBuilder($productId, $builderProductId);
    }

    public function removeSpec(array $product, array $spec)
    {
        $productId = $product['product_id'];
        $specId    = $spec['spec_id'];

        return $this->removeSpecById($productId, $specId);
    }

    public function removeSpecById($productId, $specId)
    {
        return $this->getEntityMapper()->removeSpec($productId, $specId);
    }

    public function insert($dataOrModel)
    {
        $vars = array(
            'data' => $dataOrModel
        );

        $this->getEventManager()->trigger('insert.pre', $this, $vars);

        $id = parent::insert($data);
        $vars['result'] = $id;

        $this->getEventManager()->trigger('insert.post', $this, $vars);

        return $this->find(array('product_id' => $id));
    }

    public function populateForPricing($product)
    {
        //recursive options (only whats needed for pricing)
        //productUoms, Availabilities
        //
    }

    public function getByCategoryId($categoryId)
    {
        return $this->getEntityMapper()->getByCategoryId($categoryId);
    }

    /**
     * @return optionService
     */
    public function getOptionService()
    {
        if (null === $this->optionService) {
            $this->optionService = $this->getServiceLocator()->get('speckcatalog_option_service');
        }
        return $this->optionService;
    }

    /**
     * @param $optionService
     * @return self
     */
    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }

    /**
     * @return productUomService
     */
    public function getProductUomService()
    {
        if (null === $this->productUomService) {
            $this->productUomService = $this->getServiceLocator()->get('speckcatalog_product_uom_service');
        }

        return $this->productUomService->setEnabledOnly($this->enabledOnly());
    }

    /**
     * @param $productUomService
     * @return self
     */
    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }

    /**
     * @return imageService
     */
    public function getImageService()
    {
        if (null === $this->imageService) {
            $this->imageService = $this->getServiceLocator()->get('speckcatalog_product_image_service');
        }
        return $this->imageService;
    }

    /**
     * @param $imageService
     * @return self
     */
    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }

    /**
     * @return documentService
     */
    public function getDocumentService()
    {
        if (null === $this->documentService) {
            $this->documentService = $this->getServiceLocator()->get('speckcatalog_document_service');
        }
        return $this->documentService;
    }

    /**
     * @param $documentService
     * @return self
     */
    public function setDocumentService($documentService)
    {
        $this->documentService = $documentService;
        return $this;
    }

    /**
     * @return specService
     */
    public function getSpecService()
    {
        if (null === $this->specService) {
            $this->specService = $this->getServiceLocator()->get('speckcatalog_spec_service');
        }
        return $this->specService;
    }

    /**
     * @param $specService
     * @return self
     */
    public function setSpecService($specService)
    {
        $this->specService = $specService;
        return $this;
    }

    /**
     * @return companyService
     */
    public function getCompanyService()
    {
        if (null === $this->companyService) {
            $this->companyService = $this->getServiceLocator()->get('speckcatalog_company_service');
        }
        return $this->companyService;
    }

    /**
     * @param $companyService
     * @return self
     */
    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }

    /**
     * @return builderService
     */
    public function getBuilderService()
    {
        if (null === $this->builderService) {
            $this->builderService = $this->getServiceLocator()->get('speckcatalog_builder_product_service');
        }
        return $this->builderService;
    }

    /**
     * @param $builderService
     * @return self
     */
    public function setBuilderService($builderService)
    {
        $this->builderService = $builderService;
        return $this;
    }

    /**
     * @return categoryService
     */
    public function getCategoryService()
    {
        if (null === $this->categoryService) {
            $this->categoryService = $this->getServiceLocator()->get('speckcatalog_category_service');
        }
        return $this->categoryService;
    }

    /**
     * @param $categoryService
     * @return self
     */
    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
        return $this;
    }

    /**
     * @return choiceService
     */
    public function getChoiceService()
    {
        if (null === $this->choiceService) {
            $this->choiceService = $this->getServiceLocator()->get('speckcatalog_choice_service');
        }
        return $this->choiceService;
    }

    /**
     * @param $choiceService
     * @return self
     */
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }
}
