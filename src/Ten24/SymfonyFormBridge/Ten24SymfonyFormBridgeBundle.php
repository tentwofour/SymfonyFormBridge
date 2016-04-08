<?php

namespace Ten24\SymfonyFormBridge;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Ten24\SymfonyFormBridge\DependencyInjection\FormBridgeExtension;
use Ten24\SymfonyFormBridge\DependencyInjection\TwigBridgeExtension;

class Ten24SymfonyFormBridgeBundle extends Bundle
{
    /**
     * @var string
     */
    private $configurationAlias;

    /**
     * Ten24SymfonyFormBridgeBundle constructor.
     *
     * @param string $alias
     */
    public function __construct($alias = 'ten24_form')
    {
        $this->configurationAlias = $alias;
    }

    /**
     * @return \Ten24\SymfonyFormBridge\DependencyInjection\FormBridgeExtension
     */
    public function getContainerExtension()
    {
        return new FormBridgeExtension($this->configurationAlias);
    }
}