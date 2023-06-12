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
    Route::get('membros', 'members')->name('members');
    Route::get('contato', 'contact')->name('contact');
    Route::post('contato-post', 'contactUsPost')->name('contactUsPost');
    Route::get('sobre', 'about')->name('about');
    Route::middleware(['auth'])->group(function () {
        Route::get('cidades-quadrilatero', 'fontes')->name('fontes');
        Route::get('relatos-quadrilatero', 'relatosQuadrilatero')->name('relatosQuadrilatero');
        Route::get('relatos-quadrilatero/{id}', 'detalhesRelatosQuadrilatero')->name('detalhesRelatosQuadrilatero');
        Route::get('historico-ibge/{id}', 'ibgeHistorico')->name('ibgeHistorico');
        Route::get('arquivo-publico/{id}', 'arquivoPublico')->name('arquivoPublico');
        Route::get('biblioteca-nacional/{id}', 'bibliotecaNacional')->name('bibliotecaNacional');
        Route::get('visulizar-relato-documento/{id}', 'viewRelatoDoc')->name('viewRelatoDoc');
        Route::middleware(['checkRole:admin'])->group(function () {

            Route::get('inserir-relato-quadrilatero', 'inserirRelatoQuadrilatero')->name('inserirRelatoQuadrilatero');
            Route::get('inserir-documento', 'inserirCidadeDocumento')->name('inserirCidadeDocumento');
            Route::get('deletar-documento/{id}', 'deletarCidadeDocumento')->name('deletarCidadeDocumento');

            Route::post('inserir-relato-quadrilatero-post', 'inserirRelatoQuadrilateroPost')->name('inserirRelatoQuadrilateroPost');
            Route::post('inserir-documento-post', 'inserirCidadeDocumentoPost')->name('inserirCidadeDocumentoPost');
            Route::post('inserir-cidade-post', 'inserirCidadePost')->name('inserirCidadePost');

            Route::get('deletar-arquivo-relato-quadrilatero/{id}', 'deletarRelatoQuadrilateroPost')->name('deletarRelatoQuadrilateroPost');
        });
    });
});


Route::controller(\App\Http\Controllers\AuthPages::class)->group(function () {
    Route::get('entrar', 'login')->name('login');
    Route::get('registrar', 'register')->name('register');
    Route::get('sair', 'logout')->name('logout');
    Route::get('confirmar-email', 'confirmEmail')->name('confirmEmail');
    Route::get('senha-esquecida', 'forgotPassword')->name('forgotPassword');
    Route::get('nova-senha', 'newPassword')->name('newPassword');

    Route::post('entrando', 'logging')->name('logging');
    Route::post('registrando', 'registering')->name('registering');
    Route::post('senha-esquecida-post', 'forgotPasswordPost')->name('forgotPasswordPost');
    Route::post('nova-senha-post', 'newPasswordPost')->name('newPasswordPost');
    Route::delete('', 'deleteUser')->name('deleteUser');

});
