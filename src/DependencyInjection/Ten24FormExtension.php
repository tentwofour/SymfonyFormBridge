<?php

namespace Ten24\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\Kernel;

class Ten24FormExtension extends Extension
{
    /**
     * @param array                                                   $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);
        $loader        = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach ($config as $key => $value) {
            if ($value) {
                if ('help' === $key && $this->hasCoreType()) {
                    @trigger_error('Key "ten24_form.help" is deprecated since version 1.1 and will be removed in 1.2, use the built-in Symfony Core FormType instead.', \E_USER_DEPRECATED);
                }

                $loader->load($key.'.yml');
            }
        }
    }

    /**
     * @return bool
     */
    private function hasCoreType(): bool
    {
        return (class_exists('\Symfony\Component\HttpKernel\Kernel') && Kernel::VERSION >= 4.1);
    }
}
