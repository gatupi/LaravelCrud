<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/meu-nome', function () {
    return '<h1 style="color: blue">Gabriel Alonso</h1>';
});

Route::get('/ola/{nome}', function ($nome) {
    $result = "<h2 style=\"text-align: center; width: 400px; background: lightblue; margin: 20px auto; color: #333;\">Olá, $nome! Seja bem-vindo!</h2>";
    return $result;
});

// parâmetro opcional
Route::get('/seunome/{nome?}', function ($nome = null) {
    if ($nome == null) // if (isset($nome)) funciona do mesmo jeito
        return "Nenhum nome foi informado... :(";
    return "Como vai, $nome?";
});

// com regras
Route::get('/rota-com-regras/{nome}/{n}', function ($nome, $n) {
    if ($n < 0)
        return "Número não pode ser negativo. Valor passado: $n";

    if ($n == 0)
        return "Nada para exibir, você passou zero.";

    $result = '';
    for ($i = 0; $i < $n; $i++) {
        $result .= "<h3 style=\"color: darkblue\">" . ($i + 1) . ": $nome</h3>";
    }
    return $result;
})->where('nome', '[a-zA-Z]+')->where('n', '-?[0-9]+');

Route::prefix('application')->group(function () {
    Route::get('/', function () {
        return "<h1>MEU APP</h1>";
    })->name('app');

    Route::get('/inicio', function () {
        return "<h1>INICIO</h1>";
    })->name('app.inicio');

    Route::get('/testes', function () {
        return view('testando');
    })->name('app.test');

    Route::get('/user', function () {
        return view('user');
    })->name('app.user');

    Route::get('/profile', function () {
        return view('profile');
    })->name('app.profile');
});

Route::redirect('perfil3', 'application/user', 301);

Route::get('meu-perfil', function() {
    return redirect()->route('app.profile'); // utiliza o name para evitar forte dependência
});

//---------------------------------------

// erro 419
Route::post('/requisicoes', function(Request $request){
    return 'Hello POST!';
});

// linked with controller

Route::get('products', 'MinhaController@getAllProducts');
Route::get('good-morning', 'MinhaController@goodMorning');
Route::get('mathop/{n1}/{n2}/{operator}', 'MinhaController@mathOp');

Route::resource('customer', 'CustomerController'); // gera todas as rotas necessárias para os métodos na controller gerados com o parâmetro --resource
Route::resource('product', 'ProductController');
Route::resource('brand', 'BrandController');
Route::resource('product-category', 'ProductCategoryController');

Route::prefix('products')->group(function () {
    Route::get('/', function() {
        return view('products.index');
    })->name('products.index');
});

Route::prefix('cities')->group(function() {
    Route::get('/', function() {
        return view('cities.index');
    })->name('cities.index');
});