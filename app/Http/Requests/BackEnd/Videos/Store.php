<?php

namespace App\Http\Requests\BackEnd\Videos;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest{
    public function rules(): array{
        return [
            'name' => 'required|max:191',
            'meta_keywords' => 'max:191',
            'meta_des' => 'max:191',
            'des' => 'required|min:10',
            'youtube' => 'required| min:10|url'  ,
            'cat_id' => 'required|integer',
            'published' => 'required' ,
            'image' => 'image'
        ];
    }
}
