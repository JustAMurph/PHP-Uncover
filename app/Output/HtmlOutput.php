<?php

namespace App\Output;

use App\Analysis\IHandleAnalysisFeatures;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class HtmlOutput implements IHandleOutput, IHandleAnalysisFeatures
{
    private $data = [];

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
        $this->data['entryPoints'] = $routes;
    }

    public function output(): string
    {
        $css = public_path('css/report.css');

        if (file_exists($css)) {
            $css = file_get_contents($css);
        } else {
            $css = '';
        }

        $result = View::make('output/file_report', $this->data + ['style' => $css]);
        return $result->render();
    }

    public function write(\SplFileInfo $path): bool
    {
        $contents = $this->output();
        return file_put_contents($path . DIRECTORY_SEPARATOR . 'report.html', $contents);
    }
}
