<?php

declare(strict_types=1);

namespace MauticPlugin\MZagmajsterSentryBundle\Exception;

class MauticSentryPluginException extends \Exception
{
    /**
     * @param string $message
     * @param int    $code
     */
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }
}
