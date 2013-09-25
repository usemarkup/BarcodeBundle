<?php

namespace Markup\BarcodeBundle\Twig;

use Markup\BarcodeBundle\Generator\Provider as GeneratorProvider;

/**
* A Twig extension for barcode rendering.
*/
class Extension extends \Twig_Extension
{
    /**
     * @var GeneratorProvider
     **/
    private $generatorProvider;

    /**
     * @param GeneratorProvider $generatorProvider
     **/
    public function __construct(GeneratorProvider $generatorProvider)
    {
        $this->generatorProvider = $generatorProvider;
    }

    /**
     * {@inheritdoc}
     **/
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('markup_barcode_data_uri', array($this, 'getBarcodeDataUri'), array('is_safe' => array('all'))),
        );
    }

    /**
     * Gets a data URI for a barcode for the provided text, using the provided barcode definition name.
     *
     * @param  string $text
     * @param  string $definitionName
     * @return string
     **/
    public function getBarcodeDataUri($text, $definitionName)
    {
        $generator = $this->generatorProvider->getNamedGenerator($definitionName);

        return $generator->generateBarcodeDataUriForText(strval($text));
    }

    /**
     * {@inheritdoc}
     **/
    public function getName()
    {
        return 'markup_barcode';
    }
}
