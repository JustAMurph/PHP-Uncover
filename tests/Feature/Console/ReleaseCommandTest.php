<?php

namespace Console;

use Tests\TestCase;

class ReleaseCommandTest extends TestCase
{

    public function test_all()
    {
        $this->artisan('find:all', ['dir' => $this->cakePHP()->getRealPath()])
            ->assertExitCode(0);
    }

    public function test_routes()
    {
        $this->artisan('find:routes', ['dir' => $this->cakePHP()->getRealPath()])
            ->assertExitCode(0);
    }

    public function test_configs()
    {
        $this->artisan('find:config', ['dir' => $this->cakePHP()->getRealPath()])
            ->assertExitCode(0);
    }

    public function test_credentials()
    {
        $this->artisan('find:credentials', ['dir' => $this->cakePHP()->getRealPath()])
            ->assertExitCode(0);
    }
}
