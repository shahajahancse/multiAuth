<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware('auth')->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');
});

/*
* Admin route
*/
Route::namespace('Admin')->prefix('admin')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');

    /**
     * password reset route
     */
    Route::get('password/reset', 'ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'ForgetPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('admin.password.update');

    Route::middleware('auth:admin')->group(function (){
        Route::get('home', 'HomeController@index')->name('admin.home');
        Route::post('logout', 'LoginController@logout')->name('admin.logout');
    });
});
