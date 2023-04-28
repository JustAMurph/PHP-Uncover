<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function company()
    {
        return view('signup/company');
    }

    public function details(Request $request)
    {
        $company = $request->get('company');
        if (!$company) {
            return redirect(route('signup:company'));
        }

        return view('signup/details', ['company' => $request->get('company')]);
    }

    public function store(Request $request)
    {
       Organisation::createWithUser($request->get('company'), $request->only('name', 'email', 'role', 'password'));
        return redirect(route('login'))->with('info', 'User Created! Please sign in.');
    }
}
