<?php

namespace App\Http\Controllers;

use App\Events\Models\Users\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with(['posts']);
        return UsersResource::collection($user->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

        event(new EmailVerification($user));

        $response = [

            'user' => $user,
            'token' => $token

        ];

        return response($response, 201 );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UsersResource($user);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request, User $user)
    {

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


    /**
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request, User $user)
    {

        $request->user()->token()->revoke();

        return response([
            'message' => 'Logged out'
        ], 201);

    }
}
