<?php

namespace Tests\Feature\Plugins\Slim;

use App\Plugins\Slim\ConfigParser;
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
        $file = $this->slim('app/settings.php');

        $settings = new ConfigParser();
        $configs = $settings->parseFile($file);
        $this->assertEquals(4, $configs->count());
    }
}
