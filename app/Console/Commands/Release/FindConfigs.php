<?php

namespace App\Console\Commands\Release;

use App\Analysis\Analysis;
use App\Config\ConfigFile;
use App\Console\Commands\BaseCommand;
use App\Output\OutputHandler;
use App\Plugins\PluginMapping;

class FindConfigs extends BaseCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'find:config';

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
            ->settings($analysis->settings())
            ->end();

        return 0;
    }
}
