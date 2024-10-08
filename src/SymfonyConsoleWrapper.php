<?php

/**
 * This file is part of tomkyle/find-run-test
 */

namespace tomkyle\FindRunTest;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class SymfonyConsoleWrapper
{
    public function __construct(protected TestRunnerInterface $testRunner) {}

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        if ($this->testRunner instanceof ConfigurableTestRunnerInterface) {
            $config = $input->getOption('config');
            if ($config) {
                $this->testRunner->setConfig($config);
            }

            $colors = Process::isTtySupported();
            $this->testRunner->useColors($colors);
        }

        $file = $input->getArgument('file');
        return ($this->testRunner)($file);
    }

}
