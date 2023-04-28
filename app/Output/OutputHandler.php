<?php

namespace App\Output;

use App\Analysis\IHandleAnalysisFeatures;
use App\Config\ConfigFileCollection;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\InputInterface;

class OutputHandler implements IHandleAnalysisFeatures
{

    private IHandleAnalysisFeatures $output;
    private InputInterface $input;

    public function __construct(InputInterface $input)
    {
        $this->output = OutputMapper::get($input->getOption('output'));
        $this->input = $input;
    }

    public function entrypoints(Collection $entrypoints): static
    {
        $this->output->entrypoints($entrypoints);
        return $this;
    }

    public function credentials(ConfigFileCollection $credentials): static
    {
        $this->output->credentials($credentials);
        return $this;
    }

    public function settings(ConfigFileCollection $settings): static
    {
        $this->output->settings($settings);
        return $this;
    }

    public function routes(Collection $routes) : static
    {
        $this->output->routes($routes);
        return $this;
    }

    public function end()
    {
        if ($path = $this->input->getOption('write')) {
            $this->output->write(new \SplFileInfo($path));
        } else {
            echo $this->output->output();
        }
    }
}
