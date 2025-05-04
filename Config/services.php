<?php

declare(strict_types=1);

use Mautic\CoreBundle\DependencyInjection\MauticCoreExtension;
use MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory\SentryFactory;
use MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory\SentryHandlerFactory;
use Sentry\Monolog\Handler;
use Sentry\State\HubInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $excludes = [];

    $services->load(
        'MauticPlugin\\MZagmajsterSentryBundle\\',
        '../'
    )
        ->exclude('../{'.implode(',', array_merge(MauticCoreExtension::DEFAULT_EXCLUDES, $excludes)).'}');

    // Core Hub factory
    $services->set(SentryFactory::class)
        ->args([
            service('mautic.helper.core_parameters'),
        ]);

    $services->alias('mzagmajster.sentry.factory.sentry_factory', SentryFactory::class);

    $services->set(HubInterface::class)
        ->factory([service(SentryFactory::class), '__invoke']);

    // Monolog Handler factory
    $services->set(SentryHandlerFactory::class)
        ->args([
            service(HubInterface::class),
        ]);

    $services->set('mzagmajster.sentry.handler.sentry', Handler::class)
        ->factory([service(SentryHandlerFactory::class), 'create']);
};
