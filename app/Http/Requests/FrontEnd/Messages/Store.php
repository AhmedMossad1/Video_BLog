<?php

namespace App\Http\Requests\FrontEnd\Messages;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|min:10|email',
            'message'=> 'required|min:10'
        ];
    }
}
