<?php

namespace App\Console\Commands\Release;

use App\Analysis\Analysis;
use App\Config\ConfigFile;
use App\Console\Commands\BaseCommand;
use App\Output\OutputHandler;
use App\Output\OutputMapper;
use App\Plugins\PluginMapping;

class FindCredentials extends BaseCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'find:credentials';

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
            ->credentials($analysis->credentials())
            ->end();

        return 0;
    }
}
