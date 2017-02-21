<?php

namespace App\Http\Requests;

use Http\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     * 
     * @return array
     */ 
    public function rules()
    {
        return [
            // code...
        ];
    }
    
    
    /**
     * Messages of validation
     * 
     * @return array
     */ 
    public function messages()
    {
        return [
            // code...
        ];
    }
    
    
    /**
     * Get the validation rules that apply to the request file.
     * 
     * @return array
     */ 
    public function files()
    {
        return [
            // code...
        ];
    }
}