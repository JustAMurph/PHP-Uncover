<?php

namespace Tests;

use App\Analysis\Analysis;
use App\Plugins\CodeIgniter3\CodeIgniter3;

trait PerformsAnalysis
{
    protected function testAnalysis()
    {
        $analysis = new Analysis(
            new \SplFileInfo(base_path('TestApplications/Codeigniter3/')),
        );
        $analysis->detectPlugin();

        return $analysis;
    }

    protected function cakePHP($path = '') : \SplFileInfo
    {
        return $this->applicationPath('CakePHP4', $path);
    }

    protected function codeigniter($path = '') : \SplFileInfo
    {
        return $this->applicationPath('CodeIgniter3', $path);
    }

    protected function laravel($path = '') : \SplFileInfo
    {
        return $this->applicationPath('Laravel', $path);
    }

    protected function slim($path = '') : \SplFileInfo
    {
        return $this->applicationPath('Slim', $path);
    }

    protected function symfony($path = '') : \SplFileInfo
    {
        return $this->applicationPath('Symfony', $path);
    }

    protected function applicationPath($application, $path)
    {
        return new \SplFileInfo(base_path('TestApplications/' . $application . '/' . $path));
    }
}
