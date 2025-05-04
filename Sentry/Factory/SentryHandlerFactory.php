<?php

declare(strict_types=1);

namespace MauticPlugin\MZagmajsterSentryBundle\Sentry\Factory;

use Monolog\Logger;
use Sentry\Monolog\Handler;
use Sentry\State\HubInterface;

class SentryHandlerFactory
{
    private HubInterface $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }

    public function create(): Handler
    {
        $level     = Logger::toMonologLevel($_ENV['MAUTIC_SENTRY_MONOLOG_LEVEL'] ?? 'error');
        $bubble    = filter_var($_ENV['MAUTIC_SENTRY_MONOLOG_BUBBLE'] ?? 'true', FILTER_VALIDATE_BOOLEAN);
        $fillExtra = filter_var($_ENV['MAUTIC_SENTRY_MONOLOG_FILL_EXTRA_CONTEXT'] ?? 'true', FILTER_VALIDATE_BOOLEAN);

        return new Handler($this->hub, $level, $bubble, $fillExtra);
    }
}
