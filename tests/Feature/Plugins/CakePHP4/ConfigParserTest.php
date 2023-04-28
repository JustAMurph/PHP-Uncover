<?php

namespace Tests\Feature\Plugins\CakePHP4;

use App\Plugins\CakePHP4\ConfigParser;
use Tests\PerformsAnalysis;
use Tests\TestCase;

class ConfigParserTest extends TestCase
{
    use PerformsAnalysis;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_config_parse()
    {
        $config = $this->cakePHP('config/app.php');
        $parser = new ConfigParser();
        $result = $parser->parseFile($config);

        $error = $result->get('Error');
        $this->assertEquals('E_ALL', $error['errorLevel']);
    }
}
