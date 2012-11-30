<?php

namespace SpeckCatalog\Service;

interface FormServiceAwareInterface
{
    /**
     * Get formService.
     *
     * @return formService.
     */
    function getFormService();

    /**
     * Set formService.
     *
     * @param formService the value to set.
     */
    function setFormService($formService);
}
