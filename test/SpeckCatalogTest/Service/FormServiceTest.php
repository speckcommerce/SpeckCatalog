<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class FormServiceTest extends \PHPUnit_Framework_TestCase
{

    public function getService()
    {
        return new \SpeckCatalog\Service\FormService();
    }

    public function testGetFormReturnsFormModel()
    {
    }

    public function testGetKeyFieldsReturnsArrayOfFieldsAndValues()
    {
    }
}
