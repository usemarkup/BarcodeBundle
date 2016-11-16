<?php

namespace Markup\BarcodeBundle\Generator;

use Markup\BarcodeBundle\Definition\Definition;
use Markup\BarcodeBundle\Definition\DefinitionInterface;
use Markup\BarcodeBundle\Definition\DefinitionProvider;
use Markup\BarcodeBundle\Factory\Factory;

/**
* A provider of definition objects.
*/
class Provider
{
    /**
     * A configuration array with names as keys.
     *
     * @var array
     **/
    private $configuration;

    /**
     * @var DefinitionProvider
     **/
    private $definitionProvider;

    /**
     * @var Factory
     **/
    private $barcodeFactory;

    /**
     * @var Base64Encoder
     **/
    private $base64Encoder;

    /**
     * @param array              $configuration
     * @param DefinitionProvider $definitionProvider
     * @param Factory            $factory
     * @param Base64Encoder      $base64Encoder
     **/
    public function __construct(
        array $configuration,
        DefinitionProvider $definitionProvider,
        Factory $factory,
        Base64Encoder $base64Encoder
    ) {
        $this->configuration = $configuration;
        $this->definitionProvider = $definitionProvider;
        $this->barcodeFactory = $factory;
        $this->base64Encoder = $base64Encoder;
    }

    /**
     * Gets the named definition object.
     *
     * @param  string              $name
     * @return GeneratorInterface
     **/
    public function getNamedGenerator($name)
    {
        return new Generator($this->getDefinition($name), $this->barcodeFactory, $this->base64Encoder);
    }

    /**
     * Gets the definition to use for the provided definition alias.
     *
     * @param  string              $name
     * @return DefinitionInterface
     * @throws \LogicException     if the provided name does not refer to an existing definition
     **/
    private function getDefinition($name)
    {
        $definition = $this->definitionProvider->fetchDefinition($name);
        if ($definition) {
            return $definition;
        }
        if (!isset($this->configuration[$name])) {
            throw new \LogicException(sprintf('Request an unknown barcode definition with name "%s".', $name));
        }
        $config = $this->configuration[$name];

        return new Definition(
            $name,
            $config['type'],
            $config['format'],
            isset($config['image_options']) ? $config['image_options'] : [],
            isset($config['barcode_options']) ? $config['barcode_options'] : []
        );
    }
}
