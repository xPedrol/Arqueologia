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
    Route::get('/historia', 'history')->name('history');
    Route::get('/contato', 'contactUs')->name('contactUs');
    Route::post('contato/post', 'contactUsPost')->name('contactUsPost');
    Route::get('termosDeUso', 'useTerms')->name('useTerms');
});

Route::middleware(['checkRole:adm,est'])->group(function () {
    Route::controller(\App\Http\Controllers\Admin::class)->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::put('editarDocumento', 'editDocument')->name('documentEdit');
            Route::match(array('GET', 'POST'), 'inserirDocumento', 'insertDocument')->name('documentAdd');
            Route::get('deletar/{id}', 'deleteDocument')->name('deleteDocument');
            Route::get('deletarDocumento/{id}', 'deleteDocumentArchive')->name('documentArchiveDelete');
        });
    });
});
Route::middleware(['checkRole:adm'])->group(function () {
    Route::controller(\App\Http\Controllers\Admin::class)->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            Route::get('usuarios', 'users')->name('users');
            Route::match(array('GET', 'POST'), 'inserirUsuario', 'insertUser')->name('insertUser');
            Route::get('ativarUsuario', 'toggleUserActive')->name('toggleUserActive');
            Route::get('trocarPermissao', 'toggleUserPermission')->name('toggleUserPermission');
            Route::get('deletarUsuario', 'deleteUser')->name('deleteUser');
        });
    });
});

Route::controller(\App\Http\Controllers\AuthPages::class)->group(function () {
    Route::get('entrar', 'login')->name('login');
    Route::get('registrar', 'register')->name('register');
    Route::get('sair', 'logout')->name('logout');

    Route::post('logging', 'logging')->name('logging');
    Route::post('registering', 'registering')->name('registering');
});
