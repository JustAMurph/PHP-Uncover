<?php

namespace App\Console\Commands\Release;

use App\Analysis\Analysis;
use App\Console\Commands\BaseCommand;
use App\Output\IHandleOutput;
use App\Output\OutputHandler;
use App\Plugins\PluginMapping;
use Illuminate\Console\Command;

class FindVulnerabilities extends BaseCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'find:vulnerabilities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $analysis = Analysis::fromInput($this->input);

        (new OutputHandler($this->input))
            ->entrypoints($analysis->vulnerabilities())
            ->end();

        return 0;
    }
}
