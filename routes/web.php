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
    Route::middleware(['checkRole:admin'])->group(function () {
        Route::get('usuarios', 'users')->name('users');
    });
    Route::get('/', 'home')->name('home');
    Route::get('associados', 'members')->name('members');
    Route::get('contato', 'contact')->name('contact');
    Route::post('contato-post', 'contactUsPost')->name('contactUsPost');
    Route::get('sobre', 'about')->name('about');
    Route::middleware(['auth'])->group(function () {
        Route::get('sitios-arqueologicos', 'sitiosArqueologicos')->name('sitiosArqueologicos');
        Route::get('sitio-arqueologico/{id}', 'dadosSitioArqueologico')->name('dadosSitioArqueologico');
        Route::get('bibliografias', 'bibliografias')->name('bibliografias');
        Route::get('bibliografia/{id}', 'detalhesBibliografia')->name('detalhesBibliografia');
        Route::get('cidades-quadrilatero', 'cidadesQuadrilatero')->name('fontes');
        Route::get('relatos-quadrilatero', 'relatosQuadrilatero')->name('relatosQuadrilatero');
        Route::get('relatos-quadrilatero/{id}', 'detalhesRelatosQuadrilatero')->name('detalhesRelatosQuadrilatero');
        Route::get('historico-ibge/{id}', 'ibgeHistorico')->name('ibgeHistorico');
        Route::get('arquivo-publico/{id}', 'arquivoPublico')->name('arquivoPublico');
        Route::get('biblioteca-nacional/{id}', 'bibliotecaNacional')->name('bibliotecaNacional');
        Route::get('visulizar-relato-documento/{id}', 'viewRelatoDoc')->name('viewRelatoDoc');
        Route::get('visulizar-relato-bibliografia/{id}', 'viewRelatoBibliografiaDoc')->name('viewRelatoBibliografiaDoc');
        Route::middleware(['checkRole:admin,intern'])->group(function () {
            Route::get('inserir-bibliografia', 'inserirBibliografia')->name('inserirBibliografia');
            Route::get('inserir-relato-quadrilatero', 'inserirRelatoQuadrilatero')->name('inserirRelatoQuadrilatero');
            Route::get('inserir-documento', 'inserirCidadeDocumento')->name('inserirCidadeDocumento');

            Route::post('inserir-bibliografia-post', 'inserirBibliografiaPost')->name('inserirBibliografiaPost');
            Route::post('inserir-relato-quadrilatero-post', 'inserirRelatoQuadrilateroPost')->name('inserirRelatoQuadrilateroPost');
            Route::post('inserir-documento-post', 'inserirCidadeDocumentoPost')->name('inserirCidadeDocumentoPost');
            Route::post('inserir-cidade-post', 'inserirCidadePost')->name('inserirCidadePost');
            Route::post('inserir-sitio-arqueologico-post', 'inserirSitioArqPost')->name('inserirSitioArqPost');

            Route::get('deletar-sitio-arqueologico/{id}', 'deletarSitioArq')->name('deletarSitioArq');
            Route::get('deletar-cidade/{id}', 'deletarCidade')->name('deletarCidade');
            Route::get('deletar-documento/{id}', 'deletarCidadeDocumento')->name('deletarCidadeDocumento');
            Route::get('deletar-bibliografia/{id}', 'deletarBibliografia')->name('deletarBibliografia');
            Route::get('deletar-relato-quadrilatero/{id}', 'deletarRelatoQuadrilatero')->name('deletarRelatoQuadrilatero');
            Route::get('deletar-arquivo-relato-quadrilatero/{id}', 'deletarRelatoQuadrilateroDoc')->name('deletarRelatoQuadrilateroDoc');
            Route::get('deletar-arquivo-bibliografia/{id}', 'deletarBibliografiaDoc')->name('deletarBibliografiaDoc');
        });
    });
});


Route::controller(\App\Http\Controllers\AuthPages::class)->group(function () {
    Route::get('entrar', 'login')->name('login');
    Route::get('registrar', 'register')->name('register');
    Route::get('sair', 'logout')->name('logout');
    Route::get('confirmar-email', 'confirmEmail')->name('confirmEmail');
    Route::get('recuperar-senha', 'forgotPassword')->name('forgotPassword');
    Route::get('nova-senha', 'newPassword')->name('newPassword');

    Route::post('entrando', 'logging')->name('logging');
    Route::post('registrando', 'registering')->name('registering');
    Route::post('recuperar-senha-post', 'forgotPasswordPost')->name('forgotPasswordPost');
    Route::post('nova-senha-post', 'newPasswordPost')->name('newPasswordPost');

});

Route::controller(\App\Http\Controllers\Profile::class)->group(function () {
    Route::get('minha-conta', 'myAccount')->name('myAccount');
    Route::post('minha-conta-post', 'savingAccountChanges')->name('savingAccountChanges');
});
Route::controller(\App\Http\Controllers\Admin::class)->group(function () {
    Route::middleware(['checkRole:admin'])->group(function () {
        Route::get('inserir-usuario', 'insertUser')->name('insertUser');
        Route::get('deletar-usuario', 'deleteUser')->name('deleteUser');
        Route::get('ativar-usuario', 'toggleUserActive')->name('toggleUserActive');
        Route::get('trocar-permissao', 'toggleUserPermission')->name('toggleUserPermission');

        Route::post('inserir-usuario-post', 'insertUserPost')->name('insertUserPost');
    });
});
