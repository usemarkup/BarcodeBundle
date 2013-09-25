<?php

namespace Markup\BarcodeBundle;

use Markup\BarcodeBundle\DependencyInjection\Compiler\AddGeneratorDefinitionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MarkupBarcodeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddGeneratorDefinitionsPass());
    }
}
