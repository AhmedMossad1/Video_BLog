<?php

namespace App\Http\Requests\FrontEnd\Comments;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{

    public function rules()
    {
        return [
            'comment' => ['required' ,'min:10' , 'max:2000'],
        ];
    }
}
