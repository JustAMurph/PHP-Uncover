<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SamplesController extends Controller
{
    public function index()
    {
        return view('samples/index');
    }

    public function download($framework): BinaryFileResponse
    {
        $available = [
            'CakePHP4',
            'CodeIgniter3',
            'Laravel',
            'Slim',
            'Symfony'
        ];

        if (!in_array($framework, $available)) {
            abort(404);
        }

        $file = Storage::path('applications/' . $framework . '.zip');
        return response()->download($file);
    }
}
