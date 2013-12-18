<?php

namespace Markup\BarcodeBundle\Definition;

/**
* A simple provider object that can provide named definitions passed to it.
*/
class DefinitionProvider
{
    /**
     * @var DefinitionInterface[]
     **/
    private $definitions = array();

    /**
     * Fetches a definition for the given name. Returns null if the definition does not exist.
     *
     * @param  string                   $name
     * @return DefinitionInterface|null
     **/
    public function fetchDefinition($name)
    {
        if (!isset($this->definitions[$name])) {
            return null;
        }

        return $this->definitions[$name];
    }

    /**
     * Sets a definition onto the provider.
     *
     * @param  string              $name
     * @param  DefinitionInterface $definition
     * @return self
     **/
    public function setDefinition($name, DefinitionInterface $definition)
    {
        $this->definitions[$name] = $definition;

        return $this;
    }
}
