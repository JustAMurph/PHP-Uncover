<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {

        $users = User::organisationOwned($this->organisation())
            ->get();

        return view('users/index', ['users' => $users]);
    }

    public function create()
    {
        return view('users/create', []);

    }

    public function store(Request $request)
    {
        $user = new User($request->only('name', 'email', 'role'));
        $user->password = Hash::make($request->get('password'));
        $user->organisation()->associate($this->organisation());
        $user->save();

        return redirect(route('users'))->with('info', 'User Created');
    }

    public function delete(Request $request)
    {
        $user = User::organisationOwned($this->organisation())
            ->where('id', $request->post('user_id'))
            ->first();

        $user->delete();

        return redirect(route('users'))->with('info', 'User Deleted');
    }
}
