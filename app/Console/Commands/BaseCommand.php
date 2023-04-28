<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class BaseCommand extends Command
{
    /**
     * Arguments to use throughout the application.
     *
     * @return array[]
     */
    protected function getArguments()
    {
        return [
            ['dir', InputArgument::REQUIRED, 'The directory to parse.']
        ];
    }

    /**
     * Setup the global options for the application.
     *
     * @return array[]
     */
    protected function getOptions()
    {
        return [
            ['output', null, InputOption::VALUE_OPTIONAL, 'The output format.', 'cli'],
            ['write', null, InputOption::VALUE_OPTIONAL, 'Where to write the output format. Leave blank for console.'],
            ['config', null, InputOption::VALUE_OPTIONAL, 'An optional config file to parse']
        ];
    }
}
