<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Organisation;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class EvaluationController extends Controller
{
    public function info()
    {
        return view('evaluation/info');
    }

    public function download()
    {
        return view('evaluation/download');
    }

    public function login()
    {
        $faker = Factory::create();

        $user = [
            'email' => $faker->email(),
            'password' => 'abcdef12355',
            'name' => $faker->name(),
            'role' => 'Security Evaluator'
        ];

        list($organisation, $user) = Organisation::createWithUser($faker->company(), $user);
        /**
         * @var Organisation $organisation
         */
        $application = new Application(['name' => 'My Application']);
        $organisation->applications()->save($application);


        Auth::login($user);
        Session::put('evaluation', true);
        return redirect(route('dashboard'))->with('info', 'Welcome! Please click on the \'Scans\' tab to get started!');
    }
}
