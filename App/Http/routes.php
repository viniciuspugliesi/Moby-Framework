<?php

use Routing\Route;
use Hash\Hash;

Route::setUppercase(true);


Route::get('/', function(){
    // return view('welcome');
    
    $senha = 'ola mundo';
    $hash = Hash::make($senha);
    
    var_dump($hash);
    // $hash  = '$2a$08$NjM5MjczNDY2NTg5MzcxZOOgjvt1IgC1SEdhMnRuBmSnca1aa0QL2';
    
    if (Hash::check($senha, $hash)) {
    	echo 'Senha OK!';
    } else {
    	echo 'Senha incorreta!';
    }
});
  
    
Route::get('/Index', 'Index:index');


Route::get('/Controller/{id,nome}', function($id, $nome){
    var_dump($id);
    var_dump($nome);
});
    
    
/**
 * Rest full
 */
    Route::post('/listarUsuario/{id}', 'Index:post');
    Route::get('/listarUsuario', 'Index:listar');
    Route::put('/', function(){
        
        var_dump($_SERVER['REQUEST_METHOD']);
        echo 'put /';
    });
    Route::delete('/', function(){
        
        var_dump($_SERVER['REQUEST_METHOD']);
        echo 'ta aqui delete';
    });
    
    
/**
 * Tests Group
 */
    Route::group('/Aluno', function() {
        Route::get('/1/{id,nome,email?}', function(){
            
        });
        
        Route::get('/2', function(){
            echo 'Dentro de Aluno/2';
        });
        
        
        Route::group('/Perfil', function() {
             Route::get('/dados', function(){
                echo 'Dentro de Aluno/Perfil/dados';
            });
        });
        
        Route::get('/oito', function(){
            echo 'Dentro de Aluno/oito';
        });
    });
    
/**
 * Tests Middleware
 */
    Route::middleware('admin', function() {
        Route::get('/Admin', function() {
            echo 'aqui';
        });
        Route::get('/Admin/cadastrar', function() {
            echo 'get';
        });
        Route::post('/Admin/cadastrar', function() {
            echo 'post';
        });
        Route::put('/Admin/cadastrar', function() {
            echo 'put';
        });
        Route::delete('/Admin/cadastrar', function() {
            echo 'delete';
        });
    });
    
    Route::middleware('usuario', function() {
        Route::get('/perfilAluno/{teste}', function($teste) {
            echo 'aqui';
            var_dump($teste);
        });
        Route::get('/perfilAluno1', function() {
            echo 'aqui41';
        });
        Route::get('/perfilAluno12', function() {
            echo 'aqudfi41';
        });
    });