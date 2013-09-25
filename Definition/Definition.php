<?php

namespace Markup\BarcodeBundle\Definition;

/**
* A barcode definition.
*/
class Definition implements DefinitionInterface
{
    /**
     * @var string
     **/
    private $name;

    /**
     * @var string
     **/
    private $type;

    /**
     * @var string
     **/
    private $imageFormat;

    /**
     * @var array
     **/
    private $imageOptions;

    /**
     * @var array
     **/
    private $barcodeOptions;

    /**
     * @param string $name
     * @param string $type
     * @param string $imageFormat
     * @param array  $imageOptions
     * @param array  $barcodeOptions
     **/
    public function __construct($name, $type, $imageFormat, array $imageOptions = array(), array $barcodeOptions = array())
    {
        $this->name = $name;
        $this->type = $type;
        $this->imageFormat = $imageFormat;
        $this->imageOptions = $imageOptions;
        $this->barcodeOptions = $barcodeOptions;
    }

    /**
     * {@inherit}
     **/
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     **/
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     **/
    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    /**
     * {@inheritdoc}
     **/
    public function getImageOptions()
    {
        return $this->imageOptions;
    }

    /**
     * {@inheritdoc}
     **/
    public function getBarcodeOptions()
    {
        return $this->barcodeOptions;
    }
}
