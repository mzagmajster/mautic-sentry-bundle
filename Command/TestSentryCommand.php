<?php

declare(strict_types=1);

namespace MauticPlugin\MZagmajsterSentryBundle\Command;

use Mautic\CoreBundle\Command\ModeratedCommand;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\CoreBundle\Helper\PathsHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestSentryCommand extends ModeratedCommand
{
    public function __construct(
        protected PathsHelper $pathsHelper,
        private CoreParametersHelper $coreParametersHelper,
        private LoggerInterface $mauticLogger
    ) {
        parent::__construct($pathsHelper, $coreParametersHelper);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('mz:sentry:test')
            ->setDescription('Execute command to test integration with Sentry');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io        = new SymfonyStyle($input, $output);
        $io->success('Command will fail if Sentry is not configured - do not panic :).');

        if (!$this->checkRunStatus($input, $output)) {
            return 0;
        }

        $this->mauticLogger->error('Testing Sentry Monolog integration...');
        $this->completeRun();

        return 0;
    }
}
