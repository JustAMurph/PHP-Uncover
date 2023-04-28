<?php

namespace Tests\Feature\Plugins\Laravel;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\Plugins\Laravel\RouteParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteParserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_parse_routes()
    {
        $application = $this->laravel();
        $stub = $this->createMock(ApplicationDefinitions::class);
        $parser = new RouteParser($stub);
        $result = $parser->parse($application);
        $this->assertEquals(6, $result->count());
    }
}
