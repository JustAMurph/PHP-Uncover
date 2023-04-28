<?php

namespace Tests\Feature\Plugins\CodeIgniter3;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\Plugins\CodeIgniter3\ConfigParser;
use App\Plugins\CodeIgniter3\FileRouteParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileRouteParserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_file_route_parse()
    {
        $application = $this->codeigniter();

        $stub = $this->createMock(ApplicationDefinitions::class);

        // Configure the stub.
        $stub->method('findClassByNameAndMethod')
            ->willReturn('abc');
        $parser = new FileRouteParser($stub);
        $result = $parser->parse($application);
        $this->assertEquals(1, $result->count());
    }
}
