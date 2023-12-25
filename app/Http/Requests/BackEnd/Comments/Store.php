<?php

namespace App\Http\Requests\BackEnd\Comments;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{

    public function rules(): array
    {
        return [
            'comment' => 'required|min:10',
            'video_id' => 'required|integer'
        ];
    }
}
