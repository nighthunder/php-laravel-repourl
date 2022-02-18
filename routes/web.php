<?php

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
})->name('home');

Route::get('/login', function () {
    return view('auth/login');
})->name('login');

Route::get('/register', function () {
    return view('auth/register');
})->name('register');

Route::get('/dashboard', 'AuthController@dashboard')->name('dashboard');

Route::get('/dashboard/login', 'AuthController@showLoginForm')->name('dashboard.login');

Route::get('/dashboard/loggout', 'AuthController@loggout')->name('dashboard.loggout.do');

Route::post('/dashboard/login', 'AuthController@login')->name('dashboard.login.do');

Route::post('/dashboard/register', 'AuthController@register')->name('dashboard.register.do');

Route::post('/dashboard/register', 'AuthController@register')->name('dashboard.register.do');

Route::get('urls.ajax', 'UrlController@paginacaoAjax')->name('urls.ajax');

Route::get('urls.add.do', 'UrlController@do')->name('urls.add.do');

Route::get('urls.lista.ajax', function(){
    return view('urlAjax');
});