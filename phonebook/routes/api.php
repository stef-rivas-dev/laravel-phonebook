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
Route::name('users.')->group(function() {
    Route::middleware(['auth:api'])->group(function() {
        Route::get('users/{user}', 'UserController@show')
            ->name('show');
        Route::get('users/{user}/contacts', 'UserController@listContacts')
            ->name('listContacts');
        Route::delete('users/{user}', 'UserController@delete')
            ->name('delete');
    });
});

/*
 Contacts routes
*/
Route::name('contacts.')->group(function() {
    Route::middleware(['auth:api'])->group(function() {
        Route::get('contacts', 'ContactController@index')
            ->name('index');
        Route::get('contacts/{contact}', 'ContactController@show')
            ->name('show');
        Route::post('contacts', 'ContactController@store')
            ->name('store');
        Route::put('contacts/{id}', 'ContactController@update')
            ->name('update');
        Route::delete('contacts/{contact}', 'ContactController@delete')
            ->name('delete');
    });
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');