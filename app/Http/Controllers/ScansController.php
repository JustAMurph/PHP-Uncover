<?php

namespace App\Http\Controllers;

use App\Analysis\Analysis;
use App\Events\Http\ScanComplete;
use App\Models\Application;
use App\Models\Scan;
use App\Plugins\Symfony\Symfony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ScansController extends Controller
{
    public function index()
    {
        $scans = $this->organisation()
            ->scans()
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get();

        return view('scans/index', ['scans' => $scans]);
    }

    public function create()
    {
        $applications = Application::organisationOwned($this->organisation())
            ->get();
        return view('scans/create', ['applications' => $applications]);
    }

    /**
     * Offset this to a queue or something else. A little over the top.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request)
    {
        $application = Application::findById($request->post('application_id'));

        $scan = new Scan();
        $scan->application()->associate($application);
        $scan->save();

        $newPath = Storage::path('uploads/' . $scan->id);
        $request->file('file')
            ->zipExtractTo($newPath);

        $analysis = new Analysis(
            new \SplFileInfo($newPath)
        );

        $config = $request->file('config');
        if ($config) {
            $path = Storage::path($config->storeAs('uploads', 'config-' . $scan->id . '.yml'));
            $analysis->useConfigFile($path);
            $configContents = file_get_contents($path);
        }

        $scan->vulnerabilities = $analysis->vulnerabilities();

        $scan->fill([
            'entrypoints' => $analysis->entryPoints(),
            'credentials' => $analysis->credentials(),
            'settings' => $analysis->settings(),
            'vulnerabilities' => $analysis->vulnerabilities(),
            'config' => $configContents ?? ''
        ]);

        $scan->update();

        ScanComplete::dispatch($scan, $this->user());

        return response()->json(['success' => true, 'scan_id' => $scan->id]);
    }

    public function status(Request $request)
    {

    }

    public function delete($id)
    {
        $scan = $this->organisation()
            ->scans()
            ->where('scans.id', $id)
            ->first();

        if ($scan) {
            $scan->delete();
            Session::flash('info', 'Scan deleted successfully.');
        } else {
            Session::flash('error', 'Could not delete scan.');
        }

        return redirect('/scans/');
    }

    public function view(Request $request, $id)
    {
        $scan = $this->organisation()->scans()->where('scans.id', $id)->first();
        /**
         * @var Scan $scan
         */

        $data = [
            'vulnerabilities' => $scan->vulnerabilities,
            'credentials' => $scan->credentials,
            'settings' => $scan->settings,
            'entryPoints' => $scan->entrypoints
        ];

        return view('output/web_report', $data);
    }
}
