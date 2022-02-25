<?php

namespace MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory;

use AppKernel;
use Jean85\PrettyVersions;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Sentry\Client;
use Sentry\ClientBuilder;
use Sentry\HttpClient\HttpClientFactory;
use Sentry\Integration\RequestIntegration;
use Sentry\SentrySdk;
use Sentry\State\Hub;
use Sentry\State\HubInterface;
use Sentry\Transport\DefaultTransportFactory;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttplugClient;

class SentryFactory
{
    private $coreParametersHelper;

    public function __construct(CoreParametersHelper $coreParametersHelper)
    {
        $this->coreParametersHelper = $coreParametersHelper;
    }

    public function __invoke(): HubInterface
    {
        $dsn         = $this->coreParametersHelper->get('mzagmajster_sentry_dsn');
        $environment = $this->coreParametersHelper->get('mzagmajster_sentry_environment');
        $release     = $this->coreParametersHelper->get('mzagmajster_sentry_sw_release');
        $projectRoot = $this->coreParametersHelper->get('mzagmajster_sentry_project_root');
        $cacheDir    = $this->coreParametersHelper->get('cache_path');

        $clientBuilder = ClientBuilder::create([
            'dsn'                  => $dsn ?: null,
            'environment'          => $environment, // I.e.: staging, testing, production, etc.
            'in_app_include'       => [$projectRoot],
            'in_app_exclude'       => [$cacheDir, "$projectRoot/vendor"],
            'prefixes'             => [$projectRoot],
            'release'              => $release,
            'default_integrations' => false,
            'send_attempts'        => 1,
            'tags'                 => [
                'php_uname'       => \PHP_OS,
                'php_sapi_name'   => \PHP_SAPI,
                'php_version'     => \PHP_VERSION,
                'framework'       => 'symfony',
                'symfony_version' => '4.4.26',
            ],
        ]);

        $client       = HttpClient::create(['timeout' => 2]);

        // Enable Sentry RequestIntegration
        $options = $clientBuilder->getOptions();
        $options->setIntegrations([new RequestIntegration()]);

        $client = $clientBuilder->getClient();

        // A global HubInterface must be set otherwise some feature provided by the SDK does not work as they rely on this global state
        return SentrySdk::setCurrentHub(new Hub($client));
    }
}
