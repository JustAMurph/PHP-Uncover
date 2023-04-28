<?php

namespace App\Console\Commands\Release;

use App\Analysis\Analysis;
use App\Console\Commands\BaseCommand;
use App\Output\OutputHandler;
use App\Plugins\PluginMapping;
use App\Utility\Route;
use Illuminate\Console\Command;

class FindRoutes extends BaseCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'find:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attempts to find all entry routes to the application. Including any found parameters.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $analysis = Analysis::fromInput($this->input);

        (new OutputHandler($this->input))
            ->routes($analysis->entryPoints())
            ->end();
        return 0;
    }
}
