<?php

namespace Output;

use App\Output\ConsoleOutput;
use Tests\PerformsAnalysis;
use Tests\TestCase;

class ConsoleOutputTest extends TestCase
{
    use PerformsAnalysis;
    /**
     * A basic feature test example.
     *
     *
     * @return void
     */
    public function test_console_output()
    {
        $console = new ConsoleOutput();
        $console->entrypoints($this->testAnalysis()->vulnerabilities());

        $output = $console->output();
        $this->assertStringContainsString("exec(\$_GET['command']) -> \$_GET['command']", $output);
    }
}
