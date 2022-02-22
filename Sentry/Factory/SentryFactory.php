<?php

namespace MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory;

use \AppKernel;
use Jean85\PrettyVersions;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
/*use Nyholm\Psr7\Factory\HttplugFactory;
use Nyholm\Psr7\Factory\Psr17Factory;*/
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
    private static function getConfig() {
        $config = include(__DIR__ . '/../../.plugin-env.php');
        return $config;

    }

    private static function create(
        ?string $dsn,
        string $environment,
        string $release,
        string $projectRoot,
        string $cacheDir
    ): HubInterface {
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

    public static function createHubInstance() {
        $config = self::getConfig();
        return self::create(
            $config['sentry_dsn'],
            $config['environment'],
            $config['release'],
            $config['project_root'],
            $config['cache_dir']
        );
    }
}
