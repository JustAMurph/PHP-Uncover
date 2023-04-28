<?php

namespace App\Output;

use App\Analysis\IHandleAnalysisFeatures;
use App\EntryPoint\EntryPoint;
use Illuminate\Support\Collection;

class ConsoleOutput implements IHandleOutput, IHandleAnalysisFeatures
{
    private $output = '';

    public function output(): string
    {
        return $this->output;
    }

    public function write(\SplFileInfo $path): bool
    {
        return file_put_contents($path->getPathname(), $this->output());
    }

    public function entrypoints(Collection $entrypoints)
    {
        $str = '';
        if ($entrypoints->isEmpty()) {
            $str .= 'No vulnerabilities found.';
        } else {
            $str = $this->alert('Vulnerabilities');
        }

        $heading = function(EntryPoint $vulnerableExecution) {
            $str = 'URLs: ' . PHP_EOL;
            foreach ($vulnerableExecution->route->getUrls() as $url) {
                $str .= $url . PHP_EOL;
            }
            $str .= PHP_EOL . '------' . PHP_EOL;
            return $str;
        };

        foreach($entrypoints as $vulnerability) {
            /**
             * @var EntryPoint $vulnerability
             */
            $str .= $heading($vulnerability);
            $str .= PHP_EOL . 'Description: ' . $vulnerability->vulnerability->getDescription() . PHP_EOL . PHP_EOL;

            $str .= $vulnerability->toExecutionPath();

            $str .= PHP_EOL . PHP_EOL . 'Remediation: ' . $vulnerability->vulnerability->getRemediation() . PHP_EOL . PHP_EOL;
            $str .= PHP_EOL . PHP_EOL;
        }

        $this->output .= $str . PHP_EOL;
    }

    public function credentials(Collection $credentials)
    {
        $str = $this->alert('Credentials');
        $str .= $this->getSettingsString($credentials);
        $this->output .= $str . PHP_EOL;
    }

    private function getValue($var)
    {
        if (empty($var)) {
            return '!!Empty!!';
        }

        if (is_array($var)) {
            return print_r($var, true);
        }

        return $var;
    }

    public function settings(Collection $settings)
    {
        $str = $this->alert('Settings');
        $str .= $this->getSettingsString($settings);
        $this->output .= $str;
    }

    public function routes(Collection $routes)
    {

       $str = $this->alert('Routes');
        foreach($routes as $route) {
            foreach($route->getUrls() as $url) {
                $str .= sprintf('[%s] %s',$route->getMethod(), $url) . PHP_EOL;
            }
        }

        $this->output .= $str . PHP_EOL;
    }

    private function getSettingsString(Collection $collection)
    {
        $str = '';
        foreach($collection as $item) {
            $str .= '---- ' . $item->path . ' ----' . PHP_EOL . PHP_EOL;

            foreach ($item->variables as $key => $variable) {
                $str .= $this->info($key . ': ' . $this->getValue($variable));
            }
        }

        return $str . PHP_EOL;
    }

    private function info($str)
    {
        return $str . PHP_EOL;
    }

    private function alert($str)
    {
        return str_repeat(PHP_EOL, 2) . str_repeat('*', 100) . PHP_EOL . $str . PHP_EOL . str_repeat('*', 100) . PHP_EOL . PHP_EOL;
    }
}
