<?php

namespace Markup\BarcodeBundle\Generator;

/**
 * Interface for a barcode generator.
 **/
interface GeneratorInterface
{
    /**
     * Generates and returns an image.
     *
     * @param  string                       $text
     * @return Imagine\Image\ImageInterface
     **/
    public function generateBarcodeImageForText($text);

    /**
     * Generates an HTTP response with a barcode as the content.
     *
     * @param  string                                     $text
     * @return \Symfony\Component\HttpFoundation\Response
     **/
    public function generateBarcodeResponseForText($text);

    /**
     * Generates a data URI with a barcode as the content.
     *
     * @param  string $text
     * @return string
     **/
    public function generateBarcodeDataUriForText($text);
}
