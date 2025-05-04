<?php

declare(strict_types=1);

namespace MauticPlugin\MZagmajsterSentryBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class MZagmajsterSentryExtension extends Extension
{
    /**
     * @param mixed[] $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Config'));
        $loader->load('services.php');
    }

    public function build(ContainerBuilder $container): void
    {
        // If you want to alias Sentry\State\HubInterface automatically
        $container->setAlias(\Sentry\State\HubInterface::class, 'mzagmajster.sentry.factory.sentry_factory')
            ->setPublic(true);
    }
}
