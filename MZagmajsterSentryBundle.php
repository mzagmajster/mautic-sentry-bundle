<?php

declare(strict_types=1);

namespace MauticPlugin\MZagmajsterSentryBundle;

use BGalati\MonologSentryHandler\SentryHandler;
use Doctrine\DBAL\Schema\Schema;
use Mautic\CoreBundle\Factory\MauticFactory;
use Mautic\PluginBundle\Bundle\PluginBundleBase;
use Mautic\PluginBundle\Entity\Plugin;
use MauticPlugin\MZagmajsterSentryBundle\DependencyInjection\Compiler\OverrideSentryPass;
use Sentry\State\Hub;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Sentry\State\HubInterface;
use MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory\SentryFactory;
use BGalati\MonologSentryHandler\SentryHnadler;

class MZagmajsterSentryBundle extends PluginBundleBase
{
    public function build(ContainerBuilder $container)
    {
        $definition = new Definition(HubInterface::class);
        $definition->setFactory(
            'MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory\SentryFactory::createHubInstance'
        );
        $container->setDefinition('sentry.state.hub_interface', $definition);

        $definition = new Definition(SentryHandler::class, [
            new Reference('sentry.state.hub_interface'),
            '%mautic.mzagmajster_sentry_log_level%',
            '%mautic.mzagmajster_sentry_log_bubble%'
        ]);
        $container->setDefinition('bgalati.monolog_sentry_handler.sentry_handler', $definition);
    }

    /**
     * Called by PluginController::reloadAction when the plugin version does not match what's installed.
     *
     * @param null   $metadata
     * @param Schema $installedSchema
     *
     * @throws \Exception
     */
    public static function onPluginUpdate(Plugin $plugin, MauticFactory $factory, $metadata = null, Schema $installedSchema = null)
    {
    }
}
