<?php

namespace App\Http\Requests\BackEnd\Pages;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'meta_keywords' => 'max:191',
            'meta_des' => 'max:191',
            'des' => 'required|min:10'
        ];
    }
}

