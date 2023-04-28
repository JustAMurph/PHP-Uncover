<?php

namespace Tests\Feature\Plugins\Symfony;

use App\Plugins\Symfony\ConfigParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigParserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $application = $this->symfony('config/packages/framework.yaml');
        $parser = new ConfigParser();
        $result = $parser->parseFile($application);
        $this->assertEquals(2, $result->count());
    }
}
