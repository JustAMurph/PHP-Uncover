<?php

namespace Tests\Feature\Plugins\Symfony;

use App\Plugins\Symfony\AnnotationRouteParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnnotationParserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $application = $this->symfony();

        $annotationParser = new AnnotationRouteParser();
        $result = $annotationParser->parse($application);

        $this->assertEquals(8, $result->count());
    }
}
