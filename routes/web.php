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

Route::controller(\App\Http\Controllers\Home::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('members', 'members')->name('members');
    Route::get('contact', 'contact')->name('contact');
    Route::get('about', 'about')->name('about');
    Route::middleware(['auth'])->group(function () {
        Route::get('fontes', 'fontes')->name('fontes');
        Route::get('historico-ibge/{id}', 'ibgeHistorico')->name('ibgeHistorico');
        Route::get('arquivo-publico/{id}', 'arquivoPublico')->name('arquivoPublico');
        Route::get('biblioteca-nacional/{id}', 'bibliotecaNacional')->name('bibliotecaNacional');
    });
});


Route::controller(\App\Http\Controllers\AuthPages::class)->group(function () {
    Route::get('entrar', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::get('sair', 'logout')->name('logout');

    Route::post('logging', 'logging')->name('logging');
    Route::post('registering', 'registering')->name('registering');
    Route::delete('', 'deleteUser')->name('deleteUser');
});
