<?php

declare(strict_types=1);

namespace MauticPlugin\MZagmajsterSentryBundle;

use BGalati\MonologSentryHandler\SentryHandler;
use Mautic\PluginBundle\Bundle\PluginBundleBase;
use Sentry\State\HubInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MZagmajsterSentryBundle extends PluginBundleBase
{
    public function build(ContainerBuilder $container): void
    {
        $definition = new Definition(HubInterface::class);
        $definition->setFactory(
            // 'MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory\SentryFactory::createHubInstance'
            new Reference('mzagmajster.sentry.factory.sentry_factory')
        );
        $container->setDefinition('sentry.state.hub_interface', $definition);

        $definition = new Definition(SentryHandler::class, [
            new Reference('sentry.state.hub_interface'),
            '%mautic.mzagmajster_sentry_log_level%',
            '%mautic.mzagmajster_sentry_log_bubble%',
        ]);
        $container->setDefinition('bgalati.monolog_sentry_handler.sentry_handler', $definition);
    }
}
