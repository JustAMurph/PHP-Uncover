<?php

namespace Tests\Feature\Plugins\Laravel;

use App\Parser\StatementWalker\ApplicationDefinitions;
use App\Plugins\Laravel\ConfigParser;
use App\Plugins\Laravel\RouteParser;
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
    public function test_parse_config()
    {
        $application = $this->laravel('config/app.php');
        $parser = new ConfigParser();
        $result = $parser->parseFile($application);
        $this->assertEquals(14, $result->count());
    }
}
