<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthsController extends Controller
{

    public function show() {

        return User::all();

    }

    public function shows(User $user) {

        return User::find($user);

    }

    public function register(Request $request, User $user) {

        $request->validate([

            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('blog_api')->accessToken;

        $response = [

            'user' => $user,
            'token' => $token

        ];

        return response($response, 201 );

    }

    public function login(Request $request, User $user) {

        $request->validate([

            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ( !auth()->attempt(request(['email', 'password']))) {

            return response(['message' => 'Invalid login details'], 401);
        }

        $user = Auth::user();
        $token = $request->user()->createToken('blog_api')->accessToken;

        $response = [

            'user' => $user,
            'token' => $token

        ];

        return response($response, 201 );

    }

    public function logout(Request $request) {

        $request->user()->token()->revoke();

        return response([
            'message' => 'Logged out'
        ], 201);

    }
}
