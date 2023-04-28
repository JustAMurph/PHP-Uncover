<?php

namespace Tests\Feature\Plugins\CakePHP4;

use App\Plugins\CakePHP4\ControllerRouteParser;
use Tests\PerformsAnalysis;
use Tests\TestCase;

class ControllerRouteParserTest extends TestCase
{
    use PerformsAnalysis;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_controller_route_parser()
    {
        $application = $this->cakePHP();

        $parser = new ControllerRouteParser();
        $result = $parser->parse($application);

        $this->assertEquals(6, $result->count());
    }
}
