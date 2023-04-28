<?php

namespace App\Output;

use App\Analysis\IHandleAnalysisFeatures;
use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Exception\UnsupportedException;
use Symfony\Component\Serializer\Serializer;

class OutputBuilder implements IHandleOutput, IHandleAnalysisFeatures
{
    private $data = [];
    private $format;


    public function __construct($format)
    {
        if (!in_array($format, ['yaml', 'json', 'xml'])) {
            throw new UnsupportedException('Format not supported');
        }

        $this->format = $format;
    }

    public function asFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function output(): string
    {
        $serializer = resolve(Serializer::class);
        return $this->{'get' . ucwords($this->format)}($serializer);
    }

    /**
     *
     * @param Serializer $serializer
     * @return string
     */
    private function getYaml(Serializer $serializer)
    {
        return $serializer->serialize($this->data, $this->format, ['yaml_inline' => 7]);
    }

    private function getXml(Serializer $serializer)
    {
        return $serializer->serialize($this->data, $this->format, ['xml_format_output' => true]);
    }

    private function getJson(Serializer $serializer)
    {
        return $serializer->serialize($this->data, $this->format, ['json_encode_options' => JSON_PRETTY_PRINT]);
    }

    public function write($path): bool
    {
        return true;
    }

    public function entrypoints(Collection $entrypoints)
    {
        $this->data['vulnerabilities'] = $entrypoints;
    }

    public function credentials(Collection $credentials)
    {
        $this->data['credentials'] = $credentials;
    }

    public function settings(Collection $settings)
    {
        $this->data['settings'] = $settings;
    }

    public function routes(Collection $routes)
    {
        $this->data['entrypoints'] = $routes;
    }
}
