<?php

namespace Markup\BarcodeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MarkupBarcodeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!empty($config['definitions'])) {
            $container->setParameter('markup_barcode.definition.configuration', $config['definitions']);
            foreach ($config['definitions'] as $name => $params) {
                $generator = new Definition('%markup_barcode.generator.class%', array($name));
                $generator->setFactoryService('markup_barcode.generator.provider');
                $generator->setFactoryMethod('getNamedGenerator');
                $container->setDefinition(sprintf('markup_barcode.generator.%s', $name), $generator);
            }
        } else {
            $container->setParameter('markup_barcode.definition.configuration', array());
        }

        $loader->load('services.xml');
    }
}
