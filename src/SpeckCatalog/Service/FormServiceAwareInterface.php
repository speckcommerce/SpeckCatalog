<?php

namespace SpeckCatalog\Service;

interface FormServiceAwareInterface
{
    /**
     * Get formService.
     *
     * @return formService.
     */
    public function getFormService();

    /**
     * Set formService.
     *
     * @param formService the value to set.
     */
    public function setFormService($formService);
}
