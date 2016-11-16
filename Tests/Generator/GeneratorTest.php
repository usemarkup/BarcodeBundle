<?php

namespace Markup\BarcodeBundle\Tests\Generator;

use Imagine\Image\ImageInterface;
use Markup\BarcodeBundle\Definition\DefinitionInterface;
use Markup\BarcodeBundle\Factory\Factory;
use Markup\BarcodeBundle\Generator\Base64Encoder;
use Markup\BarcodeBundle\Generator\Generator;
use Markup\BarcodeBundle\Generator\GeneratorInterface;

/**
* A test for a barcode generator that uses a definition.
*/
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->definition = $this->createMock(DefinitionInterface::class);
        $this->barcodeFactory = $this->createMock(Factory::class);
        $this->base64encoder = $this->createMock(Base64Encoder::class);
        $this->generator = new Generator($this->definition, $this->barcodeFactory, $this->base64encoder);
    }

    public function testIsGenerator()
    {
        $this->assertInstanceOf(GeneratorInterface::class, $this->generator);
    }

    public function testGenerateImage()
    {
        if (!interface_exists(ImageInterface::class)) {
            $this->markTestSkipped('The Imagine library needs to be included for this test to execute.');
        }
        $text = 'Hello world!';
        $type = 'code128';
        $this->definition
            ->expects($this->any())
            ->method('getType')
            ->will($this->returnValue($type));
        $this->definition
            ->expects($this->any())
            ->method('getBarcodeOptions')
            ->will($this->returnValue(array()));
        $image = $this->createMock(ImageInterface::class);
        $this->barcodeFactory
            ->expects($this->once())
            ->method('create')
            ->with($this->equalTo($type), $this->equalTo(array('text' => $text)))
            ->will($this->returnValue($image));
        $this->assertSame($image, $this->generator->generateBarcodeImageForText($text));
    }

    public function testGenerateResponse()
    {
        if (!interface_exists('Imagine\Image\ImageInterface')) {
            $this->markTestSkipped('The Imagine library needs to be included for this test to execute.');
        }
        $text = 'Hello world!';
        $type = 'code128';
        $imageFormat = 'jpg';
        $imageMimeType = 'image/jpeg';
        $imageOptions = array('quality' => 80);
        $this->definition
            ->expects($this->any())
            ->method('getType')
            ->will($this->returnValue($type));
        $this->definition
            ->expects($this->any())
            ->method('getBarcodeOptions')
            ->will($this->returnValue(array()));
        $this->definition
            ->expects($this->any())
            ->method('getImageFormat')
            ->will($this->returnValue($imageFormat));
        $this->definition
            ->expects($this->any())
            ->method('getImageOptions')
            ->will($this->returnValue($imageOptions));
        $image = $this->createMock(ImageInterface::class);
        $this->barcodeFactory
            ->expects($this->any())
            ->method('create')
            ->with($this->equalTo($type), $this->equalTo(array('text' => $text)))
            ->will($this->returnValue($image));
        $imageContent = 'i am the image';
        $image
            ->expects($this->any())
            ->method('get')
            ->with($this->equalTo($imageFormat), $this->equalTo($imageOptions))
            ->will($this->returnValue($imageContent));
        $response = $this->generator->generateBarcodeResponseForText($text);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertEquals($imageContent, $response->getContent());
        $this->assertEquals($imageMimeType, $response->headers->get('Content-Type'));
    }

    public function testGenerateDataUri()
    {
        if (!interface_exists('Imagine\Image\ImageInterface')) {
            $this->markTestSkipped('The Imagine library needs to be included for this test to execute.');
        }
        $text = 'Hello world!';
        $type = 'code128';
        $imageFormat = 'jpg';
        $imageMimeType = 'image/jpeg';
        $imageOptions = array('quality' => 80);
        $this->definition
            ->expects($this->any())
            ->method('getType')
            ->will($this->returnValue($type));
        $this->definition
            ->expects($this->any())
            ->method('getBarcodeOptions')
            ->will($this->returnValue(array()));
        $this->definition
            ->expects($this->any())
            ->method('getImageFormat')
            ->will($this->returnValue($imageFormat));
        $this->definition
            ->expects($this->any())
            ->method('getImageOptions')
            ->will($this->returnValue($imageOptions));
        $image = $this->createMock(ImageInterface::class);
        $this->barcodeFactory
            ->expects($this->any())
            ->method('create')
            ->with($this->equalTo($type), $this->equalTo(array('text' => $text)))
            ->will($this->returnValue($image));
        $imageContent = 'i am the image';
        $image
            ->expects($this->any())
            ->method('get')
            ->with($this->equalTo($imageFormat), $this->equalTo($imageOptions))
            ->will($this->returnValue($imageContent));
        $base64 = "4345GDFHDF3453453";
        $this->base64encoder
            ->expects($this->any())
            ->method('encode')
            ->with($this->equalTo($imageContent))
            ->will($this->returnValue($base64));
        $dataUri = sprintf('data:%s;base64,%s', $imageMimeType, $base64);
        $this->assertEquals($dataUri, $this->generator->generateBarcodeDataUriForText($text));
    }
}
