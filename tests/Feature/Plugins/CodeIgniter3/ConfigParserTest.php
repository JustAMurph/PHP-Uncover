<?php

namespace Tests\Feature\Plugins\CodeIgniter3;

use App\Plugins\CodeIgniter3\ConfigParser;
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
        $application = $this->codeigniter('application/config/config.php');
        $parser = new ConfigParser();
        $result = $parser->parseFile($application);
        $this->assertEquals(count($result->get('config')), 50);
    }
}
