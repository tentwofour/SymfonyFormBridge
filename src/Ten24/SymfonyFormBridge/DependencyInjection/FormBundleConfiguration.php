<?php

namespace Ten24\SymfonyFormBridge\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class FormBundleConfiguration implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $alias;

    /**
     * TwigBundleConfiguration constructor.
     *
     * @param $alias
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root($this->alias);

        return $treeBuilder;
    }
}
