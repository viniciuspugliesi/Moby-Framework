<?php

namespace App\Http\Requests;

use Http\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * 
     * @return array
     */ 
    public function rules()
    {
        // return [
        //     'nm_email_usuario'  => 'email',
        //     'nm_senha_usuario'  => 'required'
        // ];
    }
    
    
    /**
     * 
     * @return array
     */ 
    public function messages()
    {
        // return [
        //     'nm_senha_usuario.required' => 'A senha é obrigatória',
        //     'nm_email_usuario.email'    => 'Email invalido',
        // ];
    }
    
    
    /**
     * 
     * @return array
     */ 
    public function files()
    {
        // return [
        //     'file'  => 'required',
        //     'file2' => 'required'
        // ];
    }
}