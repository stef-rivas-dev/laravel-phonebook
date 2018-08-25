<?php

use App\User;
use App\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 User routes
*/
Route::middleware('auth:api')->group(function() {
    Route::get('user', 'UserController@show');
    Route::get('users/{user}/contacts', 'UserController@listContacts');
    Route::delete('users/{user}', 'UserController@delete');
});

/*
 Contacts routes
*/
Route::middleware(['auth:api'])->group(function() {
    Route::get('contacts', 'ContactController@index');
    Route::get('contacts/{contact}', 'ContactController@show');
    Route::post('contacts', 'ContactController@store');
    Route::put('contacts/{id}', 'ContactController@update');
    Route::delete('contacts/{contact}', 'ContactController@delete');
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');