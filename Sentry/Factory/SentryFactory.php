<?php

namespace MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory;

use Mautic\CoreBundle\Helper\CoreParametersHelper;
use MauticPlugin\MZagmajsterSentryBundle\Exception\MauticSentryPluginException;
use Sentry\ClientBuilder;
use Sentry\SentrySdk;
use Sentry\State\Hub;
use Sentry\State\HubInterface;

class SentryFactory
{
    public function __construct(
        private CoreParametersHelper $coreParametersHelper,
    ) {
    }

    public function __invoke(): HubInterface
    {
        $dsn         = $_ENV['SENTRY_DSN'] ?? null;
        if (null === $dsn) {
            throw new MauticSentryPluginException('Sentry DSN is empty.');
        }

        $environment = $_ENV['APP_ENV'] ?? 'prod';
        $release     = \MAUTIC_VERSION;
        $projectRoot = \MAUTIC_ROOT_DIR;
        $cacheDir    = $this->coreParametersHelper->get('cache_path');

        $clientBuilder = ClientBuilder::create([
            'dsn'                  => $dsn,
            'environment'          => $environment,
            'in_app_include'       => [$projectRoot],
            'in_app_exclude'       => [$cacheDir, "$projectRoot/vendor"],
            'prefixes'             => [$projectRoot],
            'release'              => $release,
            'default_integrations' => true,
        ]);

        $client = $clientBuilder->getClient();
        if (null === $client) {
            throw new \RuntimeException('Sentry client is null. Check DSN and configuration.');
        }

        $hub = new Hub($client);
        SentrySdk::setCurrentHub($hub);

        return $hub;
    }
}
