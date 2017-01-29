<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class [#class#] extends Request
{
    public function rules()
    {
        return [
            // 'email' =>  'required|valid_email',
        ];
    }
    
    public function files()
    {
        return [
            // 'file' => 'required|extension[jpg,png,jpeg]|max_size[1MB]',
        ];
    }
}