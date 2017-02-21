<?php

namespace App\Http\Controllers;

use Http\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\Teste;

use Validation\Validation;
use Session\Session;
use Mail\Mail;
use DateTime\Times;

use App\Models\Cidade;

class IndexController extends Controller
{
    public function index()
    {
        echo 'indexController'. "<br>";
        $post = Times::all();
        // var_dump(Cidade::find(10));
        
        // Session::set('teste', 'testando a session');
        
        // var_dump(Session::get('teste'));
        
        // $usuario = new Usuario();
        // $usuario->teste();
        
        // return view('index', [
        //     'var' => [
        //         'teste' => 'testando'
        //     ]
        // ]);
        
        // return redirect()->back();
        
        // var_dump($request);
        
        // var_dump(
        //     Mail::from('vinicius_pugliesi@outlook.com')
        //     ->subject('teste')
        //     ->address('vinicius_pugliesi@outlook.com')
        //     ->body('teste')
        //     ->send()
        // );
        
        // var_dump(Times::now());
        
    }
    
    
    public function get($id, $nome)
    {
        var_dump($id);
        var_dump($nome);
    }
    
    
    public function post(Request $request)
    {
        echo 'aqui no post';
        
        // var_dump($request);
        // var_dump($id);
        
        // var_dump($request->filter_input('nm_email_usuario', FILTER_VALIDATE_EMAIL));
        
        // if (!$request->run()) {
        //     var_dump($request->getErrors());
        // } else {
        //     echo 'Nenhum erro';
        // }
        
        // Validation::rules($request->input(), [
        //     'nm_email_usuario' => 'required|email',
        //     'nm_senha_usuario' => 'required'
        // ], [
            // 'nm_senha_usuario.required' => 'A senha é obrigatória',
            // 'nm_email_usuario.email' => 'Email invalido',
        // ]);
        
        // if (!Validation::run()) {
        //     var_dump(Validation::getErrors());
        // } else {
        //     echo 'Nenhum erro';
        // }
        
        // var_dump($request->isValid());
        // var_dump($request->getErrors());
        
        
        // $file = $request->file('file1');
        // var_dump($file->setDestiny('/file')->save());
        
        // var_dump($file->save());
        
        // var_dump($file);
        
        // var_dump($file->get_erros());
        
        // var_dump($file->getExtension('file'));
    }
    
    
    public function listar()
    {
        echo 'Dentro da função listar';
    }
}