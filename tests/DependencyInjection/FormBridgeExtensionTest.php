<?php

namespace Ten24\Tests\Bundle\FormBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;
use Ten24\Bundle\FormBundle\DependencyInjection\Ten24FormExtension;

class Ten24FormExtensionTest extends TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    public function testExtensionConstructorWithDefaultNamespace()
    {
        $loader = new Ten24FormExtension();
        self::assertEquals('ten24_form', $loader->getAlias());
    }

    public function testLoadWithEmptyConfiguration()
    {
        $this->createEmptyConfiguration();
        $this->assertNotHasDefinition('ten24_form.extension.help');
    }

    public function testLoadWithDisabledEmailExtension()
    {
        $this->createHelpDisabledConfiguration();

        $this->assertNotHasDefinition('ten24_form.extension.help');
    }


    public function testLoadWithAllExtensionsDisabled()
    {
        $this->createAllDisabledConfiguration();

        $this->assertNotHasDefinition('ten24_form.extension.help');
    }

    public function testLoadDefaultTwigExtensionClasses()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Ten24\Component\Form\Extension\Type\HelpTypeExtension', 'ten24_form.extension.help.class');
    }

    /**
     * getEmptyConfig.
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml   = <<<EOF
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @return mixed
     */
    protected function getFullConfig()
    {
        $yaml   = <<<EOF
help: true
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function getFullDisabledConfig()
    {
        $yaml   = <<<EOF
help: false
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new Ten24FormExtension();
        $config              = $this->getEmptyConfig();
        $loader->load([$config], $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    protected function createHelpDisabledConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new Ten24FormExtension();
        $config              = $this->getFullConfig();

        $config['help'] = false;

        $loader->load([$config], $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    protected function createAllDisabledConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader              = new Ten24FormExtension();
        $config              = $this->getFullDisabledConfig();

        $loader->load([$config], $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        self::assertSame($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        self::assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        self::assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
