<?php

namespace Markup\BarcodeBundle\Definition;

/**
 * An interface for a definition for a type of barcode.
 **/
interface DefinitionInterface
{
    /**
     * A barcode type (e.g. 'code39', 'code128', etc)
     *
     * @return string
     **/
    public function getType();

    /**
     * The name of this definition.
     *
     * @return string
     **/
    public function getName();

    /**
     * Gets the image format - jpg, jpeg, gif, png, wbmp and xbm are expected formats (anything Imagine can deal with)
     *
     * @return string
     **/
    public function getImageFormat();

    /**
     * Gets the options for rendering the image (used by Imagine: @see http://imagine.readthedocs.org/en/latest/usage/introduction.html#save-images)
     *
     * @return array
     **/
    public function getImageOptions();

    /**
     * Gets the barcode options array to be passed to the Zend barcode factory (excluding text to render).
     **/
    public function getBarcodeOptions();
}
