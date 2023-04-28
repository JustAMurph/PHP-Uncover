<?php

namespace App\Output;

use App\Analysis\IHandleAnalysisFeatures;
use App\Config\ConfigFileCollection;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Serializer\Serializer;

class CSVOutput implements IHandleOutput, IHandleAnalysisFeatures
{

    private $files = [];
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = resolve(Serializer::class);
    }

    public function entrypoints(Collection $entrypoints)
    {
        // TODO: Implement vulnerabilities() method.
        $this->files['vulnerabilities.csv'] = $this->serializer->serialize($entrypoints, 'csv');
    }

    public function credentials(ConfigFileCollection $credentials)
    {
        $this->files['credentials.csv'] = $this->serializer->serialize($credentials->toCsvArray(), 'csv');
    }

    public function settings(ConfigFileCollection $settings)
    {
        $this->files['settings.csv'] = $this->serializer->serialize($settings->toCsvArray(), 'csv');
    }

    public function routes(Collection $routes)
    {
        $csv = [];

        foreach($routes as $route) {
            foreach($route->getUrls() as $url) {
                $csv[] = [
                    'method' => $route->getMethod(),
                    'url' => $url
                ];
            }
        }

        $this->files['routes.csv'] = $this->serializer->serialize($csv, 'csv');
    }

    public function output(): string
    {
        throw new InvalidOptionException('Cannot output csv to console. Use --write instead.');
    }

    public function write(\SplFileInfo $path): bool
    {
        foreach($this->files as $file => $csv) {
            file_put_contents($path->getPathname() . DIRECTORY_SEPARATOR . $file, $csv);
        }

        return true;
    }
}
