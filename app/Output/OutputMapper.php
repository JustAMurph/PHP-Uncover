<?php

namespace App\Output;

use App\Analysis\IHandleAnalysisFeatures;

class OutputMapper
{
    public static function get($mapping) : IHandleOutput|IHandleAnalysisFeatures
    {
        if ($mapping == 'cli') {
            return new ConsoleOutput();
        }

        if ($mapping == 'html') {
            return new HtmlOutput();
        }

        if ($mapping == 'csv') {
            return new CSVOutput();
        }

        if (in_array($mapping, ['xml', 'yaml', 'json'])) {
            return new OutputBuilder($mapping);
        }
    }
}
