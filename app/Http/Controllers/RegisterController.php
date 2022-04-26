<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;
use Auth;
class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $userRole = Role::where('slug', '=', 'user')->first();
        $user->role()->associate($userRole);

        $user->password = Hash::make($request->input('password'));
        $user->save();

        Auth::login($user);
        return redirect()->route('recipe.index');
    }
}
