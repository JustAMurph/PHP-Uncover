<?php

namespace Tests\Feature\Plugins\Slim;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\Plugins\Slim\RouteParser;
use App\Plugins\Slim\ConfigParser;
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
    public function test_example()
    {
        $stub = $this->createMock(ApplicationDefinitions::class);

        // Configure the stub.
        $stub->method('findClassByName')
            ->willReturn('abc');

        $parser = new RouteParser($stub);
        $routes = $parser->parse($this->slim());

        $this->assertEquals(6, $routes->count());
    }
}
