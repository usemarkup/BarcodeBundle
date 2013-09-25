<?php

namespace Markup\BarcodeBundle\Tests\Definition;

use Markup\BarcodeBundle\Definition\DefinitionProvider;

/**
* Test for a provider of definitions.
*/
class DefinitionProviderTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->provider = new DefinitionProvider();
    }

    public function testEmptyProviderProvidesNothing()
    {
        $this->assertNull($this->provider->fetchDefinition('disnae'));
    }

    public function testFetchDefinition()
    {
        $exists = 'does_exist';
        $noExists = 'does_not_exist';
        $definition = $this->getMock('Markup\BarcodeBundle\Definition\DefinitionInterface');
        $this->provider->setDefinition($exists, $definition);
        $this->assertSame($definition, $this->provider->fetchDefinition($exists));
        $this->assertNull($this->provider->fetchDefinition($noExists));
    }
}
