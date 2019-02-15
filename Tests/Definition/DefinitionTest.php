<?php

namespace Markup\BarcodeBundle\Tests\Definition;

use Markup\BarcodeBundle\Definition\Definition;
use Markup\BarcodeBundle\Definition\DefinitionInterface;
use PHPUnit\Framework\TestCase;

/**
* A test for a barcode definition
*/
class DefinitionTest extends TestCase
{
    public function setUp()
    {
        $this->type = 'type';
        $this->name = 'name';
        $this->imageFormat = 'png';
        $this->imageOptions = ['flatten' => true];
        $this->barcodeOptions = ['barcode' => 'options'];
        $this->definition = new Definition($this->name, $this->type, $this->imageFormat, $this->imageOptions, $this->barcodeOptions);
    }

    public function testIsDefinition()
    {
        $this->assertInstanceOf(DefinitionInterface::class, $this->definition);
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
