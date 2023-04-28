<?php

namespace Tests\Feature\Output;

use App\Output\OutputBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Yaml\Yaml;
use Tests\PerformsAnalysis;
use Tests\TestCase;

class OutputBuilderTest extends TestCase
{
    use PerformsAnalysis;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_xml()
    {

        $output = new OutputBuilder('xml');
        $output->entrypoints($this->testAnalysis()->entryPoints());

        $xml = simplexml_load_string($output->output());
        $this->assertIsObject($xml);
    }

    public function test_json()
    {
        $output = new OutputBuilder('json');
        $output->entrypoints($this->testAnalysis()->entryPoints());

        $json = json_decode($output->output());
        $this->assertIsObject($json);
    }

    public function test_yaml()
    {
        $output = new OutputBuilder('yaml');
        $output->entrypoints($this->testAnalysis()->entryPoints());

        $yaml = Yaml::parse($output->output());
        $this->assertIsArray($yaml);
    }
}
