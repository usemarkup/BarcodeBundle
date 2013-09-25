<?php

namespace Markup\BarcodeBundle\Tests\Definition;

use Markup\BarcodeBundle\Definition\Definition;

/**
* A test for a barcode definition
*/
class DefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->type = 'type';
        $this->name = 'name';
        $this->imageFormat = 'png';
        $this->imageOptions = array('flatten' => true);
        $this->barcodeOptions = array('barcode' => 'options');
        $this->definition = new Definition($this->name, $this->type, $this->imageFormat, $this->imageOptions, $this->barcodeOptions);
    }

    public function testIsDefinition()
    {
        $this->assertInstanceOf('Markup\BarcodeBundle\Definition\DefinitionInterface', $this->definition);
    }

    public function testGetType()
    {
        $this->assertEquals($this->type, $this->definition->getType());
    }

    public function testGetName()
    {
        $this->assertEquals($this->name, $this->definition->getName());
    }

    public function testGetBarcodeOptions()
    {
        $this->assertEquals($this->barcodeOptions, $this->definition->getBarcodeOptions());
    }

    public function testImageFormat()
    {
        $this->assertEquals($this->imageFormat, $this->definition->getImageFormat());
    }

    public function testImageOptions()
    {
        $this->assertEquals($this->imageOptions, $this->definition->getImageOptions());
    }
}
