<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Plugin;
use App\Plugins\PluginMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ApplicationsController extends Controller
{
    public function index()
    {

        $applications = Application::organisationOwned($this->organisation())
            ->with('scans')->get();
        return view('applications/index', ['applications' => $applications]);
    }

    public function create(Request $request)
    {
        if ($request->post()) {
            $application = new Application();
            $application->fill($request->only('name'));
            $application->organisation()->associate($this->organisation());
            $application->save();

            return redirect('/applications/');
        }


        return view('applications/create', ['plugins' => PluginMapping::cases()]);
    }


    /**
     * Fix CSRF.
     *
     * @param Application $application
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function delete(Application $application)
    {
        $application->delete();

        Session::flash('message', 'Application deleted');
        return redirect('/applications');
    }
}
