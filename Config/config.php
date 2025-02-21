<?php

declare(strict_types=1);

return [
    'name'        => 'MZagmajsterSentry',
    'description' => 'Mautic & Sentry Integration',
    'version'     => '0.0.1',
    'author'      => 'Matic Zagmajster',

    'routes'      => [
        'main'   => [],  // end routes.main
        'public' => [],  // end routes.public
        'api'    => [],  // end routes.api
    ],  // end routes

    'services'    => [
        'events' => [
        ],  // end services.events

        'models' => [
        ],  // end services.models

        'integrations' => [
        ],  // end services.integrations

        'forms' => [
        ],  // end services.forms

        'helpers' => [
        ],  // end services.helpers

        'other'        => [
            'mzagmajster.sentry.factory.sentry_factory' => [
                'class'     => \MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory\SentryFactory::class,
                'arguments' => [
                    'mautic.helper.core_parameters',
                ],
            ],
        ],  // end services.other
    ],

    'menu'        => [],  // end menu
    'parameters'  => [
        'mzagmajster_sentry_dsn'          => 'https://73968020075a99d503e7fa4f900b4a48@sentry.sos-sw.si/23',
        'mzagmajster_sentry_environment'  => 'production',
        'mzagmajster_sentry_sw_release'   => '1.0.7',
        'mzagmajster_sentry_log_level'    => \Monolog\Logger::ERROR,
        'mzagmajster_sentry_log_bubble'   => true,
        'mzagmajster_sentry_project_root' => '/var/www/html',
    ],
];
