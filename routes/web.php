<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

if( App::environment('local')){

    Route::get('/mail', function () {

        $user = \App\Models\User::factory()->make();
        \Illuminate\Support\Facades\Mail::to($user)
        ->send(new \App\Mail\WelcomeMail($user));
        return null;
    });


}
