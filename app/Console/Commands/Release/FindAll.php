<?php

namespace App\Console\Commands\Release;

use App\Analysis\Analysis;
use App\Console\Commands\BaseCommand;
use App\Output\OutputHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FindAll extends BaseCommand
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'find:all';

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
            ->credentials($analysis->credentials())
            ->routes($analysis->entryPoints())
            ->settings($analysis->settings())
            ->end();

        return 0;
    }
}
