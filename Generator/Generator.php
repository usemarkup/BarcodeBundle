<?php

namespace Markup\BarcodeBundle\Generator;

use Markup\BarcodeBundle\Definition\DefinitionInterface;
use Markup\BarcodeBundle\Factory\Factory;
use Symfony\Component\HttpFoundation\Response;
use Imagine\Image\ImageInterface;

/**
* A barcode generator that uses barcode definitions.
*/
class Generator implements GeneratorInterface
{
    /**
     * The barcode definition used by this generator.
     *
     * @var DefinitionInterface
     **/
    private $definition;

    /**
     * The barcode factory (wraps Zend Barcode implementation)
     *
     * @var Factory
     **/
    private $barcodeFactory;

    /**
     * @var Base64Encoder
     **/
    private $base64Encoder;

    /**
     * @param DefinitionInterface $definition
     * @param Factory             $factory
     * @param Base64Encoder       $base64Encoder
     **/
    public function __construct(DefinitionInterface $definition, Factory $factory, Base64Encoder $base64Encoder)
    {
        $this->definition = $definition;
        $this->barcodeFactory = $factory;
        $this->base64Encoder = $base64Encoder;
    }

    /**
     * {@inheritdoc}
     **/
    public function generateBarcodeImageForText($text)
    {
        return $this->barcodeFactory->create($this->definition->getType(), array_merge($this->definition->getBarcodeOptions(), array('text' => $text)));
    }

    /**
     * {@inheritdoc}
     **/
    public function generateBarcodeResponseForText($text)
    {
        $image = $this->generateBarcodeImageForText($text);
        $response = new Response($this->getBinaryStringForImage($image));
        $response->headers->set('Content-Type', $this->getMimeTypeForImageFormat($this->definition->getImageFormat()));

        return $response;
    }

    /**
     * {@inheritdoc}
     **/
    public function generateBarcodeDataUriForText($text)
    {
        $image = $this->generateBarcodeImageForText($text);

        return sprintf(
            'data:%s;base64,%s',
            $this->getMimeTypeForImageFormat($this->definition->getImageFormat()),
            $this->base64Encoder->encode($this->getBinaryStringForImage($image))
        );
    }

    /**
     * Gets the mime type to use for a given format.
     *
     * @param  string $imageFormat
     * @return string
     **/
    private function getMimeTypeForImageFormat($imageFormat)
    {
        $formatMap = array(
            'jpg'           => 'image/jpeg',
            'jpeg'          => 'image/jpeg',
            'gif'           => 'image/gif',
            'png'           => 'image/png',
            'wbmp'          => 'image/vnd.wap.wbmp',
            'xbm'           => 'image/x-xbitmap',
        );
        if (!isset($formatMap[$imageFormat])) {
            return null;
        }

        return $formatMap[$imageFormat];
    }

    /**
     * @param  ImageInterface $image
     * @return string
     **/
    private function getBinaryStringForImage(ImageInterface $image)
    {
        return $image->get($this->definition->getImageFormat(), $this->definition->getImageOptions());
    }
}
