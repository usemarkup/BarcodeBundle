<?php

namespace Markup\BarcodeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

/**
* A compiler pass to add barcode generators to the container (after they may have been )
*/
class AddGeneratorDefinitionsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('markup_barcode.definition.configuration')) {
            return;
        }

        $definitions = $container->getParameter('markup_barcode.definition.configuration');

        $definitionProvider = $container->getDefinition('markup_barcode.definition_provider');

        foreach ($container->findTaggedServiceIds('markup_barcode.definition') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['alias'])) {
                    throw new InvalidArgumentException('A service tagged "markup_barcode.definition" must also declare an alias to use.');
                }
                $definitionProvider->addMethodCall('setDefinition', array($attributes['alias'], new Reference($id)));
                $container->setAlias(sprintf('markup_barcode.generator.%s', $attributes['alias']), $id);
            }
        }
    }
}
