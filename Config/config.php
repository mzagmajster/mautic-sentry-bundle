<?php

declare(strict_types=1);
require_once MAUTIC_ROOT_DIR.'/.idc-plugin-env.php';

return [
    'name'        => 'MZagmajsterSentry',
    'description' => 'Mautic Plugin Boilerplate',
    'version'     => '0.0.0',
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
            
        ],  // end services.other
    ],

    'menu'        => [],  // end menu
    'parameters'  => [
        'mzagmajster_sentry_dsn'         => \MauticPlugin\MauticIdConferenceBundle\Env\SENTRY_DSN,
        'mzagmajster_sentry_environment' => \MauticPlugin\MauticIdConferenceBundle\Env\MODE,
        'mzagmajster_sentry_sw_release'  => '1.0.7',
        'mzagmajster_sentry_log_level'   => \Monolog\Logger::ERROR,
        'mzagmajster_sentry_log_bubble'  => true
    ],
];
