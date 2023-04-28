<?php

namespace Tests\Feature\Plugins\CakePHP4;

use App\ApplicationDefinitions\ApplicationDefinitions;
use App\Plugins\CakePHP4\FileRouteParser;
use Tests\PerformsAnalysis;
use Tests\TestCase;

class FileRouteParserTest extends TestCase
{
    use PerformsAnalysis;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_file_route_parser()
    {
        $config = $this->cakePHP('config/routes.php');

        $stub = $this->createMock(ApplicationDefinitions::class);

        // Configure the stub.
        $stub->method('findClassByName')
            ->willReturn('abc');

        $parser = new FileRouteParser($stub);
        $result = $parser->parseFile($config);

        $this->assertEquals(7, $result->count());
    }
}
