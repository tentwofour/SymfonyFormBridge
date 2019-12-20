<?php

namespace Ten24\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('ten24_form');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('ten24_form');
        }

        //@formatter:off
        $rootNode
            ->children()
                ->booleanNode('help')
                    ->info("Enable the help extension")
                    ->setDeprecated('Deprecated since 1.2, to be removed in 1.3, superceded by Symfony\'s Core type')
                    ->defaultFalse()
                ->end()
            ->end();
        //@formatter:on

        return $treeBuilder;
    }
}
