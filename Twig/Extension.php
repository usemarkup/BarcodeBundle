<?php

namespace Markup\BarcodeBundle\Twig;

use Markup\BarcodeBundle\Generator\Provider as GeneratorProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
* A Twig extension for barcode rendering.
*/
class Extension extends AbstractExtension
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
        return [
            new TwigFilter('markup_barcode_data_uri', [$this, 'getBarcodeDataUri'], ['is_safe' => ['all']]),
        ];
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
}
