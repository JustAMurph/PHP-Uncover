<?php

namespace Tests\Feature\Plugins\CodeIgniter3;

use App\Parser\StatementWalker\ApplicationDefinitions;
use App\Plugins\CodeIgniter3\ControllerRouteParser;
use App\Plugins\CodeIgniter3\FileRouteParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControllerRouteParserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $application = $this->codeigniter();

        $parser = new ControllerRouteParser();
        $result = $parser->parse($application);
        $this->assertEquals(6, $result->count());
    }
}
