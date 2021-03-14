<?php

namespace Markup\BarcodeBundle\Tests\Twig;

use Markup\BarcodeBundle\Generator\GeneratorInterface;
use Markup\BarcodeBundle\Twig\Extension;
use PHPUnit\Framework\TestCase;

/**
* Test for a Twig extension for barcode rendering
*/
class ExtensionTest extends TestCase
{
    public function setUp()
    {
        $this->generatorProvider = $this->createMock('Markup\BarcodeBundle\Generator\Provider');
        $this->extension = new Extension($this->generatorProvider);
    }

    public function testIsTwigExtension()
    {
        $this->assertInstanceOf('Twig_ExtensionInterface', $this->extension);
    }

    public function testGetBarcodeDataUri()
    {
        $barcodeDataUri = 'i am a data uri';
        $text = 'barcooooode';
        $generatorName = 'default';
        $generator = $this->createMock(GeneratorInterface::class);
        $generator
            ->expects($this->any())
            ->method('generateBarcodeDataUriForText')
            ->with($this->equalTo($text))
            ->will($this->returnValue($barcodeDataUri));
        $this->generatorProvider
            ->expects($this->any())
            ->method('getNamedGenerator')
            ->with($this->equalTo($generatorName))
            ->will($this->returnValue($generator));
        $this->assertEquals($barcodeDataUri, $this->extension->getBarcodeDataUri($text, $generatorName));
    }
}
